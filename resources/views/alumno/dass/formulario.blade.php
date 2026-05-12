@extends('layouts.alumno')
@section('title', 'DASS-21')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h5 class="fw-semibold mb-0"><i class="bi bi-brain me-2 text-success"></i>Evaluación DASS-21</h5>
                <p class="text-muted small mb-0 mt-1">Escala de Depresión, Ansiedad y Estrés — responda con qué frecuencia le ocurrió cada situación en la última semana.</p>
            </div>
            <div class="card-body">
                @php
                    $opciones = [
                        0 => 'Nunca',
                        1 => 'A veces',
                        2 => 'Con bastante frecuencia',
                        3 => 'Con mucha frecuencia o casi siempre',
                    ];
                    $preguntas = [
                        1  => 'Me costó mucho relajarme.',
                        2  => 'Me di cuenta que tenía la boca seca.',
                        3  => 'No podía sentir ningún sentimiento positivo.',
                        4  => 'Se me hizo difícil respirar.',
                        5  => 'Se me hizo difícil tomar la iniciativa para hacer cosas.',
                        6  => 'Reaccioné exageradamente en ciertas situaciones.',
                        7  => 'Sentí que mis manos temblaban.',
                        8  => 'Sentí que tenía muchos nervios.',
                        9  => 'Estaba preocupado por situaciones en las cuales podía tener pánico.',
                        10 => 'Sentí que no tenía nada por qué vivir.',
                        11 => 'Noté que me agitaba.',
                        12 => 'Se me hizo difícil relajarme.',
                        13 => 'Me sentí triste y deprimido.',
                        14 => 'No toleré nada que no me dejara continuar con lo que estaba haciendo.',
                        15 => 'Sentí que iba a entrar en pánico.',
                        16 => 'Sobre nada fui capaz de entusiasmarme.',
                        17 => 'Sentí que como persona no valía mucho.',
                        18 => 'Sentí que estaba muy irritable.',
                        19 => 'Sentí los latidos de mi corazón sin haber hecho ningún esfuerzo físico.',
                        20 => 'Tuve miedo sin razón.',
                        21 => 'Sentí que la vida no tenía ningún sentido.',
                    ];
                @endphp

                <form method="POST" action="{{ route('alumno.dass.store') }}" id="dassForm">
                    @csrf

                    <div class="alert alert-info small py-2 mb-4">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Instrucciones:</strong> Para cada ítem, indique con qué frecuencia le ha ocurrido durante la semana pasada.
                    </div>

                    @foreach($preguntas as $num => $pregunta)
                        <div class="mb-4 p-3 rounded-3 {{ $errors->has("p{$num}") ? 'bg-danger bg-opacity-10 border border-danger' : 'bg-light' }}">
                            <p class="fw-medium mb-2 small">{{ $num }}. {{ $pregunta }}</p>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($opciones as $valor => $etiqueta)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="p{{ $num }}"
                                            id="p{{ $num }}_{{ $valor }}" value="{{ $valor }}"
                                            {{ old("p{$num}") == $valor ? 'checked' : '' }} required>
                                        <label class="form-check-label small" for="p{{ $num }}_{{ $valor }}">
                                            <span class="badge bg-secondary me-1">{{ $valor }}</span>{{ $etiqueta }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error("p{$num}")
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    @endforeach

                    <div class="d-flex gap-2 justify-content-end mt-4">
                        <a href="{{ route('alumno.dashboard') }}" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check2-circle me-2"></i>Enviar Evaluación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
