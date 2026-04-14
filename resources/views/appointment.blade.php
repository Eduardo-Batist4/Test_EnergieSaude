@extends('layouts.main')
@section('title', 'Rusky Vet - A saúde do seu cão em primeiro lugar')
@section('content')
	<section class="py-6 border-bottom">
		<div class="container text-center">
			<h1>Consulta #1</h1>

			<div class="row mt-4 justify-content-center">
				<div class="col-md-10 text-left">

					<div class="text-center mb-4">
                        @if(!$appointment->patient->picture)
                            <img src="{{ asset('images/default_dog.jpg')  }}" class="radius" width="40" height="40">
                        @else
                            <img src="{{ asset('storage/' . $appointment->patient->picture)  }}" class="radius" width="140" height="140">
                        @endif
					</div>

					<table class="table">
						<tbody>
                            <tr>
                                <th>Consulta</th>
                                <td>{{ $appointment->id }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ $appointment->status }}</td>
                            </tr>
                            <tr>
                                <th>Data e hora</th>
                                <td>{{ $appointment->date }} {{ $appointment->start_time }}</td>
                            </tr>
                            <tr>
                                <th>Nome do paciente</th>
                                <td>{{ $appointment->patient->name }}</td>
                            </tr>
                            <tr>
                                <th>Raça</th>
                                <td>{{ $appointment->patient->breed }}</td>
                            </tr>
                            <tr>
                                <th>Idade</th>
                                <td>7 dias</td>
                            </tr>
                            <tr>
                                <th>Dono</th>
                                <td>{{ $appointment->owner->name }}</td>
                            </tr>
                            <tr>
                                <th>Observações</th>
                                <td>{{ $appointment->notes ?? 'Nenhuma observação.' }}</td>
                            </tr>
                            <tr>
                                <th>Veterinário responsável</th>
                                <td>{{ $appointment->doctor->name }} (CRMV {{ $appointment->doctor->crmv }})</td>
                            </tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>
@endsection
<script>
    console.log($appointment);
    console.log($appointment->patient->picture);
</script>
