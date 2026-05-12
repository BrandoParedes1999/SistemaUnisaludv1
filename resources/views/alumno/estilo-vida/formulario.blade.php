@extends('layouts.alumno')
@section('title', 'Estilo de Vida PEPS-I')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h5 class="fw-semibold mb-0"><i class="bi bi-heart-pulse me-2 text-danger"></i>Evaluación PEPS-I — Estilo de Vida Saludable</h5>
                <p class="text-muted small mb-0 mt-1">Indique con qué frecuencia realiza cada actividad o comportamiento. Escala: 1=Nunca, 2=A veces, 3=Frecuentemente, 4=Siempre</p>
            </div>
            <div class="card-body">
                @php
                    $secciones = [
                        'Nutrición' => [
                            1=>'Como una dieta balanceada.',2=>'Me mantengo dentro de los 2-3 kg de mi peso corporal ideal.',
                            // Simplified - actual form has 35 questions in this section mapped to p1-p35
                            // Adding key nutrition questions here
                        ],
                    ];
                    $opciones = [1=>'Nunca',2=>'A veces',3=>'Frecuentemente',4=>'Siempre'];
                    $allPreguntas = [
                        1=>'Como una dieta balanceada.',
                        2=>'Realizo examen médico cada año.',
                        3=>'Me quiero a mí mismo.',
                        4=>'Hago ejercicio aeróbico vigoroso 3 veces por semana.',
                        5=>'Soy consciente de mis capacidades y limitaciones.',
                        6=>'Controlo mis situaciones de tensión.',
                        7=>'Me intereso por mi bienestar físico.',
                        8=>'Me siento en control de mi vida.',
                        9=>'Duermo las horas suficientes.',
                        10=>'Tengo personas significativas en mi vida.',
                        11=>'Realizo ejercicio de estiramiento.',
                        12=>'Consumo agua suficiente al día.',
                        13=>'Realizo ejercicio físico de acuerdo con mi condición.',
                        14=>'Busco ayuda cuando tengo problemas.',
                        15=>'Participo en deportes o actividades recreativas.',
                        16=>'Tomo tiempo para relajarme cada día.',
                        17=>'Reviso mi cuerpo mensualmente.',
                        18=>'Me relaciono con otros para compartir y hablar.',
                        19=>'Creo que mi vida tiene un propósito.',
                        20=>'Visito al médico regularmente.',
                        21=>'Tomo medidas para reducir el estrés.',
                        22=>'Realizo ejercicios de fortalecimiento muscular.',
                        23=>'Obtengo un examen de visión cada año.',
                        24=>'Cuento con el apoyo de personas cercanas.',
                        25=>'Me siento satisfecho con mis relaciones sociales.',
                        26=>'Practico técnicas de relajación.',
                        27=>'Trabajo hacia metas específicas a largo plazo.',
                        28=>'Discuto mis inquietudes de salud con un profesional.',
                        29=>'Soy optimista sobre mi futuro.',
                        30=>'Monitoreo mi pulso durante el ejercicio.',
                        31=>'Estoy consciente de lo que me trae satisfacción.',
                        32=>'Me hago un examen dental regularmente.',
                        33=>'Interactúo con una variedad de personas.',
                        34=>'Busco un estilo de vida estimulante e interesante.',
                        35=>'Consumo frutas y verduras diariamente.',
                        36=>'Encuentro maneras de satisfacer mis necesidades sociales.',
                        37=>'Busco crecimiento personal.',
                        38=>'Alcanzo el pulso cardíaco óptimo durante el ejercicio.',
                        39=>'Equilibro el trabajo y los momentos de ocio.',
                        40=>'Me siento amado y querido.',
                        41=>'Uso técnicas de relajación para controlar la tensión.',
                        42=>'Reviso mi presión arterial regularmente.',
                        43=>'Me siento satisfecho conmigo mismo.',
                        44=>'Expreso fácilmente mis preocupaciones.',
                        45=>'Me mantengo en calma ante las adversidades.',
                        46=>'Evito el tabaco.',
                        47=>'Tengo buenas amistades.',
                        48=>'Me reconozco como valioso.',
                    ];
                @endphp

                <form method="POST" action="{{ route('alumno.estilo-vida.store') }}">
                    @csrf
                    <div class="alert alert-info small py-2 mb-4">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>1</strong>=Nunca &nbsp;|&nbsp; <strong>2</strong>=A veces &nbsp;|&nbsp; <strong>3</strong>=Frecuentemente &nbsp;|&nbsp; <strong>4</strong>=Siempre
                    </div>

                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Pregunta</th>
                                    <th class="text-center">1</th>
                                    <th class="text-center">2</th>
                                    <th class="text-center">3</th>
                                    <th class="text-center">4</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allPreguntas as $num => $pregunta)
                                    <tr class="{{ $errors->has("p{$num}") ? 'table-danger' : '' }}">
                                        <td class="fw-bold text-muted small">{{ $num }}</td>
                                        <td class="small">{{ $pregunta }}</td>
                                        @foreach([1,2,3,4] as $val)
                                            <td class="text-center">
                                                <input type="radio" name="p{{ $num }}" value="{{ $val }}"
                                                    {{ old("p{$num}") == $val ? 'checked' : '' }} required>
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex gap-2 justify-content-end mt-4">
                        <a href="{{ route('alumno.dashboard') }}" class="btn btn-outline-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-check2-circle me-2"></i>Enviar Evaluación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
