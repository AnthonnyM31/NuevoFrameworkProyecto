<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Muestra la página de checkout.
     */
    public function checkout(Course $course)
    {
        $user = auth()->user();

        if ($user->enrollments()->where('course_id', $course->id)->exists()) {
            return redirect()->route('courses.show', $course)->with('info', 'Ya estás suscrito a este curso.');
        }

        $defaultPaymentMethod = $user->paymentMethods()->where('is_default', true)->first();

        if ($defaultPaymentMethod) {
            return view('payment.quick-checkout', compact('course', 'defaultPaymentMethod'));
        } else {
            return view('payment.checkout', compact('course'));
        }
    }

    /**
     * Procesa el pago usando PaymentService.
     */
    public function processPayment(Request $request, Course $course)
    {
        $user = auth()->user();
        $data = [];
        $shouldSaveCard = $request->boolean('save_card', false);

        // Validación y Preparación de Datos
        if ($request->has('payment_method_id')) {
            $data['payment_method_id'] = $request->input('payment_method_id');
        } else {
            $request->validate([
                'card_holder' => 'required|string|max:255',
                'card_number' => 'required|numeric|digits_between:16,16',
                'expiry_date' => 'required|string',
                'cvc' => 'required|numeric|digits:3',
            ]);

            $data = $request->only(['card_holder', 'card_number', 'expiry_date', 'cvc']);
        }

        try {
            $result = $this->paymentService->processPayment($user, $course, $data, $shouldSaveCard);

            if ($result['success']) {
                return redirect()->route('payment.success', $course)
                    ->with('transaction_id', $result['transaction_id']);
            } else {
                return redirect()->route('payment.failure', $course)
                    ->with('transaction_id', $result['transaction_id'])
                    ->with('error', $result['error']);
            }

        } catch (\Exception $e) {
            return redirect()->route('payment.failure', $course)
                ->with('error', 'Error interno al procesar el pago: ' . $e->getMessage());
        }
    }

    public function success(Course $course)
    {
        $transactionId = session('transaction_id') ?? 'N/A';
        return redirect()->route('courses.show', $course)->with(
            'success',
            "¡Felicidades! La compra y matrícula en el curso '{$course->title}' fue exitosa. ID Transacción: {$transactionId}"
        );
    }

    public function failure(Course $course)
    {
        $transactionId = session('transaction_id') ?? 'N/A';
        $error = session('error') ?? 'Error desconocido.';

        return redirect()->route('courses.show', $course)->with(
            'error',
            "Error en la compra: {$error} ID Transacción: {$transactionId}"
        );
    }
}