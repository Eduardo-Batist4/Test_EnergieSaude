@extends('layouts.main')
@section('title', 'Rusky Vet - A saúde do seu cão em primeiro lugar')
@section('content')
	<section class="py-6 border-bottom">
		<div class="container text-center">
			<h1>Consulta #1</h1>

			<div class="row mt-4 justify-content-center">
				<div class="col-md-10 text-left">

					<div class="text-center mb-4">
						<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSDJVdoqib2dry6LTBDWU_0WWvWON_zdAMn_w&usqp=CAU" class="radius" height="140">
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
                                {{-- <td>{{ $appointment->patient->user }}</td> --}}
                            </tr>
                            <tr>
                                <th>Observações</th>
                                <td>{{ $appointment->notes ?? 'Nenhuma observação.' }}</td>
                            </tr>
                            <tr>
                                <th>Veterinário responsável</th>
                                <td>{{ $appointment->user->name }} (CRMV PR-123456)</td>
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
</script>
