@extends('layouts.main')
@section('title', 'Rusky Vet - A saúde do seu cão em primeiro lugar')
@section('content')
	<section class="py-6 border-bottom">
		<div class="container text-center">
			<h1>Consulta</h1>

			<div class="row mt-4 justify-content-center">
				<div class="col-md-10 text-left">

					<div class="text-center mb-4">
                        @if(!$appointment->patient->picture)
                            <img src="{{ asset('storage/default_dog.jpg')  }}" class="radius" width="140" height="140">
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
								<td>{{ ($appointment->date) }} {{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }}</td>
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
								<td>{{ $appointment->patient->getAge() }}</td>
							</tr>
							<tr>
								<th>Dono</th>
								<td>{{ $appointment->owner->name }}</td>
							</tr>
                            <tr>
								<th>Veterinário responsável</th>
								<td>{{ $appointment->doctor->name }}</td>
							</tr>
                            @if ($appointment->status == 'completed')
                                <tr>
                                    <th>Observação</th>
                                    <td>{{ $appointment->notes }}</td>
                                </tr>
                            @endif
						</tbody>
					</table>
				</div>
			</div>
            @if ($appointment->status == 'confirmed')
                <div class="row mt-5 justify-content-center">
                    <div class="col-md-6 text-left">
                        <form action="{{ route('vet.edit-appointment', $appointment->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="notes">Observações</label>
                                <textarea name="notes" rows="7" class="form-control @error('notes') is-invalid @enderror" id="notes">{{ $appointment->notes }}</textarea>
                                @error('notes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary btn-block mt-4">Salvar e finalizar consulta</button>
                        </form>
                    </div>
                </div>
            @elseif ($appointment->status == 'pending')
                <div class="row mt-5 justify-content-center">
                    <div class="col-md-6 text-left">
                        <form action="{{ route('vet.edit-status-appointment', $appointment->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror" id="status">
                                    <option value="">Selecione</option>
                                    <option value="confirmed" {{ $appointment->status == 'confirmed' ? 'selected' : '' }}>Confirmado</option>
                                    <option value="cancelled" {{ $appointment->status == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary btn-block mt-4">Salvar</button>
                        </form>
                    </div>
                </div>
            @endif
		</div>
	</section>
@endsection
