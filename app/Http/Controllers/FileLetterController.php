<?php

namespace App\Http\Controllers;

use App\Client;
use App\FileLetter;
use App\FileLetterAssignment;
use App\FileLetterMinute;
use App\Letter;
use App\Level;
use App\Repositories\UserNotificationsRepositary;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FileLetterController extends Controller
{
    private $userNotificationsRepositary;
    public function __construct(UserNotificationsRepositary $userNotificationsRepositary)
    {
        $this->userNotificationsRepositary = $userNotificationsRepositary;
    }

    public function index($id)
    {
        $fileLetters = FileLetter::where('client_id', $id)->orderBy('created_at', 'desc')->get();

        return view('file_letters.index', compact('fileLetters'));
    }

    public function createFileLetter($id)
    {
        return view('file_letters.create', compact('id'));
    }

    public function storeFileLetter(Request $request)
    {
        $request->validate([
            'letter_title' => 'required',
            'letter_content' => 'nullable',
            'completed_at' => 'nullable',
        ]);

        $incompleteCount = FileLetter::where('client_id', $request->client_id)
            ->where('letter_status', 'Incomplete')->count();
        if ($incompleteCount > 0) {
            return redirect()->route('file.letter.view', $request->client_id)
                ->with('letter_saved_error', 'There is a processing letter in this file...');
        } else {
            $saveLetterContent = FileLetter::create([
                "client_id" => $request->client_id,
                "letter_title" => $request->post('letter_title'),
                "letter_content" => $request->post('letter_content', '<p></p>'),
            ]);
            $saveLetterContent->save();
            return redirect()->route('file.letter.view', $request->client_id)
                ->with('letter_saved', 'Letter saved successfully!');
        }
    }

    public function editLetterView($client_id, $letter_id)
    {
        $client = Client::where('id', $client_id)->first();
        $letter = FileLetter::where('id', $letter_id)->first();

        return view('file_letters.update', compact('client', 'letter'));
    }

    public function editFileLetter(Request $request, $client_id, $letter_id)
    {
        $request->validate([
            'letter_title' => 'required',
            'letter_content' => 'nullable',
        ]);

        $letter = FileLetter::where('id', $letter_id)->first();

        if ($letter->letter_status === 'Incomplete') {
            $letter->update([
                "client_id" => $client_id,
                "letter_title" => $request->get('letter_title'),
                "letter_content" => $request->get('letter_content', '<p></p>'),
            ]);
            return redirect()->route('file.letter.view', $client_id)
                ->with('success', 'Letter updated successfully!');
        }
    }

    public function viewFileLetter(FileLetter $letter)
    {
        return view('file_letters.view_letter', compact('letter'));
    }

    public function viewLetterMinuest($letter_id)
    {
        $letter = FileLetter::where('id', $letter_id)->first();
        $letterMinutes = FileLetterMinute::where('letter_id', $letter_id)->get();
        $user = Auth::user();

        return view('file_letters.letter_minutes', compact('letter', 'user', 'letterMinutes'));
    }

    public function storeFileLetterMinutes(Request $request, $letter_id)
    {
        $letterMinute = FileLetterMinute::create([
            "letter_id" => $letter_id,
            "user_id" => $request->user_id,
            "description" => $request->description,
        ]);
        $letterMinute->save();

        return redirect()->route('view.file.letter.minutes', $letter_id)
            ->with('letter_minute_added', 'Minute added!');
    }

    public function viewFileLetterAssign($letter)
    {
        $letter = FileLetter::where('id', $letter)->first();
        $levels = Level::all();
        $fileLetterAssigned = FileLetterAssignment::where('letter_id', $letter->id)->get();

        return view('file_letters.assign_letter', compact('levels', 'letter', 'fileLetterAssigned'));
    }

    public function storeFileLetterAssign(Request $request, $letter)
    {
        $user = Auth::user();

        $saveLetterAssignments = FileLetterAssignment::create([
            "letter_id" => $letter,
            "assigned_by_id" => $user->id,
            "assigned_to_id" => $request->assigned_to_id,
        ]);
        $saveLetterAssignments->save();

        $letters = FileLetter::where('id', $letter)->first();
        $client = Client::where('id', $letters->client_id)->first();

        $this->userNotificationsRepositary->makeNotification(
            $saveLetterAssignments->assigned_to_id,
            'File Letter Assigned for File No: "' . $client->file_no . '"',
            $letters->client_id
        );

        return redirect()->route('view.file.letter.assign', $letter)
            ->with('letter_assigned', 'Letter assigned!');
    }

    public function storeLetterCompleted($letter)
    {
        $letter = FileLetter::where('id', $letter)->first();
        $letter->letter_status = 'Completed';
        $letter->save();
        return redirect()->route('file.letter.view', $letter->client_id);
        // ->with('file_letter_completed', 'Letter Completed!');
    }

    public function letterFinalize(FileLetter $letter)
    {
        $letter->letter_status = 'Finalized';
        $letter->finalized_at = Carbon::now()->format('Y-m-d H:i:s');
        $letter->save();
        return redirect()->route('file.letter.view', $letter->client_id);
    }

    public function viewLetterMinutes(FileLetter $letter)
    {
        $letterMinutes = FileLetterMinute::where('letter_id', $letter->id)->get();

        return view('file_letters.view_letter_minutes', compact('letterMinutes'));
    }
}
