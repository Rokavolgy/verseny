<?php

namespace App\Http\Controllers;

use App\Models\Fordulok;
use App\Models\Language;
use App\Models\Participant;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Verseny;
use Illuminate\Support\Facades\Log;


//igazából verseny controller
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $competitions = Verseny::orderBy('verseny_ev', 'asc')
            ->get();
        return view('home', ['competitions' => $competitions]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'verseny_nev' => 'required|string|max:255',
            'verseny_ev' => 'required|integer|min:1900|max:3000',
            'verseny_terulet' => 'required|string|max:255',
            'verseny_leiras' => 'required|string|max:4000',
        ]);

        $competition = Verseny::create($validated);


        if ($request->ajax()) {
            return response()->json([
                'message' => 'Verseny sikeresen hozzáadva!',
                //'url' => route('verseny.show', $competition->id),
                //'verseny_nev' => $competition->verseny_nev,
                //'verseny_ev' => $competition->verseny_ev,
                //'description' => $competition->description,
            ]);
        }

        return redirect()->back()->with('status', 'Verseny sikeresen hozzáadva!');
    }

    public function show($id)
    {
        \DB::enableQueryLog();
        $competition = Verseny::findOrFail($id);
        $users = User::orderBy('name', 'asc')->get();
        $rounds = Fordulok::where('verseny_id', $competition->id)
            ->with('users')
            ->get();
        $queries = \DB::getQueryLog();
        $a = end($queries);
        Log::info($rounds);
        return view('verseny.show', ['competition' => $competition, 'users' => $users, 'rounds' => $rounds]);
    }

    public function list()
    {
        $competitions = Verseny::orderBy('verseny_ev', 'asc')
            ->get();

        return view('verseny.list', ['competitions' => $competitions]);
    }

    public function addRound(Request $request)
    {
        try {
            $request['verseny_id'] = intval($request['verseny_id']);
        } catch (\Exception $e) {
            return response()->json(["message" => "no"]);
        }
        $validated = $request->validate([
            'verseny_id' => 'required|exists:verseny,id',
            'kor_datum' => 'required|date_format:Y-m-d'
        ]);


        $round = new Fordulok();
        $round->verseny_id = $validated['verseny_id'];
        $round->kor_datum = $validated['kor_datum'];
        $round->save();

        return response()->json([
            'message' => 'Forduló sikeresen hozzáadva!',
            'round_id' => $round->id
        ]);
    }

    public function removeRound(Request $request)
    {
        $validated = $request->validate([
            'round_id' => 'required|integer|exists:rounds,id'
        ]);
        $fordulo = Fordulok::findOrFail($validated['round_id']);
        $fordulo->delete();
        return response()->json([
            "message" => "Forduló sikeresen törölve!"
        ]);
    }

    public function delete($id)
    {
        $competition = Verseny::findOrFail($id);
        $competition->delete();

        return response()->json(['message' => "Verseny sikeresen törölve"]);
    }

    public function listRounds(Request $request)
    {
        $rounds = Verseny::rounds();
    }

    public function addRemoveParticipant(Request $request)
    {
        Log::info($request);
        if ($request["submit"] == ("add")) {
            return $this->addParticipant($request);
        } else {
            return $this->removeParticipant($request);
        }
    }

    public function addParticipant(Request $request): JsonResponse
    {

        $validated = $request->validate([
            'round_id' => 'required|integer|exists:rounds,id',
            'user_id' => 'required|integer|exists:users,id',
        ]);


        try {
            Participant::create($validated);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'hiba'
            ]);
        }
        return response()->json([
            'message' => 'Résztvevő sikeresen hozzáadva!',
        ]);
    }

    public function removeParticipant(Request $request): JsonResponse
    {

        $validated = $request->validate([
            'round_id' => 'required|integer|exists:rounds,id',
            'user_id' => 'required|integer|exists:users,id',
        ]);


        try {
            Participant::where('round_id', $validated['round_id'])
                ->where('user_id', $validated['user_id'])
                ->delete();
        } catch (\Exception $e) {
            Log::info($e);
            return response()->json([
                'message' => 'hiba'
            ]);
        }
        return response()->json([
            'message' => 'Résztvevő sikeresen törölve!',
        ]);
    }

    public function listParticipants($id)
    {
        $round = Fordulok::findOrFail($id);
        $participants = $round->participants()->get();
        return view('verseny.listParticipants', ['competition' => $round, 'participants' => $participants]);
    }

    public function listLanguages($id)
    {
        $languages = Language::all();
        $verseny = Verseny::findOrFail($id);
        $languagesPair = $verseny->languages()->get();
        return view('verseny.language', ['competition' => $verseny, 'languages' => $languages, 'languagesPair' => $languagesPair]);
    }

    public function addLanguagetoVerseny(Request $request)
    {
        $validated = $request->validate([
            "language_id" => "required|integer|exists:languages,id",
            "verseny_id" => "required|integer|exists:verseny,id"
        ]);
        $comp = Verseny::findOrFail($validated['verseny_id']);
        $comp->languages()->attach($validated['language_id']);
        return response()->json([
            'message' => 'Nyelv hozzárendelve a versenyhez.'
        ]);
    }

    public function removeLanguagefromVerseny(Request $request)
    {
        $validated = $request->validate([
            "language_id" => "required|integer|exists:languages,id",
            "verseny_id" => "required|integer|exists:verseny,id"
        ]);
        $comp = Verseny::findOrFail($validated['verseny_id']);
        $comp->languages()->detach($validated['language_id']);
        return response()->json([
            'message' => 'Nyelv eltávolítva a versenyről.'
        ]);

    }
}
