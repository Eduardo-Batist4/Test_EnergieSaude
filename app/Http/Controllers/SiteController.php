<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Http\Requests\CreateAppointmentRequest;
use App\Http\Requests\PostEditPatientRequest;
use App\Models\Appointment;
use Illuminate\Http\Request;

use App\Models\Patient;

use Carbon\Carbon;

class SiteController extends Controller {

    public function getIndex(Request $request) {
		return view('index');
	}

	// ------------------ Cliente ------------------
	public function getClient(Request $request) {
		return view('client');
	}

	public function getEditPatient($patient_id = null) {
		$user = auth()->User();
		if (!$patient_id) {
			$patient = Patient::where([ 'user_id' => $user->id, 'name' => null ])->first();

			if (!$patient) {
				$patient = Patient::create([ 'user_id' => $user->id ]);
			}

			return redirect()->route('client.edit-patient', $patient->id);
		}
		else {
			$patient = Patient::where([ 'id' => $patient_id ])->first();
		}

		return view('edit-patient', [ 'patient' => $patient ]);
	}

	public function postEditPatient($patient_id, PostEditPatientRequest $request) {
        $patient = Patient::find($patient_id);

        $data = array_merge(
            $request->except(['birthdate', 'picture']),
            [
                'birthdate' => Carbon::createFromFormat('d/m/Y', $request->birthdate),
                'picture'   => Helper::uploadFile($request->file('picture'), 'Patient'),
            ]
        );

        $patient->update( $data );

		return redirect()->route('client')->with('toast', 'Paciente salvo com sucesso.');
	}

	public function getRemovePatient($patient_id) {
		$patient = Patient::find($patient_id);
		$patient->delete();

		return redirect()->route('client')->with('toast', 'Paciente removido com sucesso.');
	}

	public function getAppointment($appointment_id) {
		// - TODO: Retornar consulta
		$appointment = null;
		return view('appointment', [ 'appointment' => $appointment ]);
	}

	public function getCreateAppointment() {
		return view('create-appointment');
	}

    public function postCreateAppointment(CreateAppointmentRequest $request)
    {
        $user = auth()->user();
        $patientId = (int) $request['patient'];

        $patient = $user->patients()->where('id', $patientId)->first();
        if(!$patient) {
            abort(403, 'Você não é o dono desse paciente.');
        }

        $date = Carbon::createFromFormat('d/m/Y', $request->date)->toDateString();
        $appointmentExists = Appointment::where('owner_id', $user->id)
            ->where('date', $date)
            ->whereTime('start_time', $request->time)
            ->exists();

        if($appointmentExists) {
            return redirect()->back()->with('error', 'Este horário já está ocupado.');
        }

        Appointment::create([
            'patient_id' => $patientId,
            'owner_id' => $user->id,
            'doctor_id' => 2,
            'date' => $date,
            'start_time' => $request->time,
            'status' => 'pending',
        ]);

        return redirect()->route('client')->with('toast', 'Consulta marcada com sucesso.');
	}

	// ------------------ Veterinário ------------------
	public function getVet(Request $request) {
		// - TODO: Retornar todos os agendamentos
		$appointments = [];
		return view('vet', [ 'appointments' => $appointments ]);
	}

	public function getEditAppointment($appointment_id) {
		// - TODO: Retornar consulta
		$appointment = null;
		return view('edit-appointment', [ 'appointment' => $appointment ]);
	}

    public function checkAvailability(Request $request)
    {
        $date = Carbon::createFromFormat('d/m/Y', $request->date)->format('Y-m-d');

        $occupied = Appointment::where('date', $date)
                            ->pluck('start_time')
                            ->map(fn($time) => substr($time, 0, 5))
                            ->toArray();

        return response()->json($occupied);
    }
}
