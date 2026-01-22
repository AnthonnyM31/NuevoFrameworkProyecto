<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentService
{
    /**
     * Procesa una solicitud de pago.
     *
     * @param User $user
     * @param Course $course
     * @param array $paymentData Datos validados del pago/tarjeta
     * @param bool $shouldSaveCard Si se debe guardar la tarjeta para futuros usos
     * @return array Resultado de la transacción
     * @throws \Exception
     */
    public function processPayment(User $user, Course $course, array $paymentData, bool $shouldSaveCard = false): array
    {
        // 1. Simulación de Pasarela de Pago
        $isSuccessful = (rand(1, 100) <= 80); // 80% éxito
        $transactionId = (string) Str::uuid();

        $cardDetails = $this->resolveCardDetails($user, $paymentData);

        // Si es exitoso y se pidió guardar, procedemos (si es tarjeta nueva)
        if ($isSuccessful && $shouldSaveCard && !isset($paymentData['payment_method_id'])) {
            $this->savePaymentMethod($user, $paymentData);
        }

        // 2. Preparar Datos para Registro
        $recordData = [
            'user_id' => $user->id,
            'course_id' => $course->id,
            'transaction_id' => $transactionId,
            'amount' => $course->price,
            'status' => $isSuccessful ? 'succeeded' : 'failed',
            'payment_details' => $cardDetails,
        ];

        // 3. Persistencia Transaccional
        return DB::transaction(function () use ($recordData, $isSuccessful, $user, $course, $transactionId) {
            Payment::create($recordData);

            if ($isSuccessful) {
                Enrollment::firstOrCreate([
                    'user_id' => $user->id,
                    'course_id' => $course->id,
                ], [
                    'status' => 'completed',
                ]);
            }

            return [
                'success' => $isSuccessful,
                'transaction_id' => $transactionId,
                'error' => $isSuccessful ? null : 'El pago fue rechazado por la pasarela simulada.'
            ];
        });
    }

    /**
     * Resuelve los detalles de la tarjeta (sea nueva o guardada).
     */
    private function resolveCardDetails(User $user, array $data): array
    {
        if (isset($data['payment_method_id'])) {
            $method = PaymentMethod::where('user_id', $user->id)
                ->where('id', $data['payment_method_id'])
                ->firstOrFail();

            return [
                'last_four' => $method->last_four,
                'card_holder' => $method->card_holder_name,
                'method_id' => $method->id,
            ];
        }

        return [
            'last_four' => substr($data['card_number'] ?? '0000', -4),
            'card_holder' => $data['card_holder'] ?? 'Unknown',
        ];
    }

    /**
     * Guarda un nuevo método de pago.
     */
    public function savePaymentMethod(User $user, array $data): void
    {
        $expiry = explode('/', $data['expiry_date']);
        $month = (int) $expiry[0];
        $year = (int) (substr(date('Y'), 0, 2) . $expiry[1]);

        $brand = $this->getCardBrand($data['card_number']);
        $expiresAt = now()->setDate($year, $month, 1)->endOfMonth();

        $isDefault = $user->paymentMethods()->doesntExist();

        if ($isDefault) {
            // Si es el primero, aseguramos que sea default
            // (Aunque la lógica original updateaba a false, 
            //  aquí asumimos que si es el primero es true)
        }

        PaymentMethod::create([
            'user_id' => $user->id,
            'card_token' => hash('sha256', $data['card_number'] . $user->id . time()),
            'brand' => $brand,
            'last_four' => substr($data['card_number'], -4),
            'expires_at' => $expiresAt,
            'card_holder_name' => $data['card_holder'],
            'is_default' => $isDefault,
        ]);
    }

    private function getCardBrand($cardNumber): string
    {
        $firstDigit = substr($cardNumber, 0, 1);
        return match ($firstDigit) {
            '4' => 'Visa',
            '5' => 'Mastercard',
            '3' => 'Amex',
            default => 'Unknown',
        };
    }
}
