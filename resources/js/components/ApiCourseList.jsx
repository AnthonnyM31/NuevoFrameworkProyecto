import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom/client';

export default function ApiCourseList() {
    const [token, setToken] = useState(localStorage.getItem('api_token') || '');
    const [courses, setCourses] = useState([]);
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [error, setError] = useState(null);

    // Si tenemos token, cargamos cursos
    useEffect(() => {
        if (token) {
            fetchData();
        }
    }, [token]);

    const fetchData = async () => {
        try {
            const response = await fetch('/api/courses', {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                if (response.status === 401) {
                    logout();
                    return;
                }
                throw new Error('Error al cargar cursos');
            }

            const data = await response.json();
            setCourses(data);
        } catch (err) {
            setError(err.message);
        }
    };

    const handleLogin = async (e) => {
        e.preventDefault();
        setError(null);

        try {
            const response = await fetch('/api/login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({ email, password })
            });

            if (!response.ok) throw new Error('Credenciales inválidas');

            const data = await response.json();
            localStorage.setItem('api_token', data.token);
            setToken(data.token);
            setEmail('');
            setPassword('');
        } catch (err) {
            setError(err.message);
        }
    };

    const logout = () => {
        localStorage.removeItem('api_token');
        setToken('');
        setCourses([]);
    };

    if (!token) {
        return (
            <div className="p-6 bg-white rounded shadow-md max-w-sm mx-auto mt-10">
                <h2 className="text-xl font-bold mb-4">Iniciar Sesión API (React)</h2>
                {error && <p className="text-red-500 mb-2">{error}</p>}
                <form onSubmit={handleLogin}>
                    <div className="mb-4">
                        <label className="block text-gray-700">Email</label>
                        <input
                            type="email"
                            className="w-full border p-2 rounded"
                            value={email}
                            onChange={e => setEmail(e.target.value)}
                            required
                        />
                    </div>
                    <div className="mb-4">
                        <label className="block text-gray-700">Password</label>
                        <input
                            type="password"
                            className="w-full border p-2 rounded"
                            value={password}
                            onChange={e => setPassword(e.target.value)}
                            required
                        />
                    </div>
                    <button type="submit" className="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">
                        Entrar
                    </button>
                </form>
            </div>
        );
    }

    return (
        <div className="p-6 bg-white rounded shadow-md mt-10">
            <div className="flex justify-between items-center mb-6">
                <h2 className="text-2xl font-bold text-gray-800">Cursos Disponibles (Vía API)</h2>
                <button onClick={logout} className="text-red-500 underline">Cerrar Sesión</button>
            </div>

            {courses.length === 0 ? (
                <p>Cargando cursos o no hay disponibles...</p>
            ) : (
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    {courses.map(course => (
                        <div key={course.id} className="border p-4 rounded hover:shadow-lg transition">
                            <h3 className="font-bold text-lg">{course.title}</h3>
                            <p className="text-gray-600 text-sm mt-2">{course.description ? course.description.substring(0, 100) + '...' : 'Sin descripción'}</p>
                            <p className="mt-2 text-green-600 font-bold">${course.price}</p>
                            <span className="text-xs bg-gray-200 px-2 py-1 rounded mt-2 inline-block">
                                Instructor: {course.user ? course.user.name : 'N/A'}
                            </span>
                        </div>
                    ))}
                </div>
            )}
        </div>
    );
}

if (document.getElementById('react-app')) {
    const root = ReactDOM.createRoot(document.getElementById('react-app'));
    root.render(<ApiCourseList />);
}
