<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Student;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    // Student Side
    public function studentIndex()
    {
        $student = auth()->user()->student;
        if (!$student) {
            return redirect()->route('siswa.dashboard')->with('error', 'Silakan isi biodata terlebih dahulu.');
        }
        $messages = $student->messages()->orderBy('created_at', 'asc')->get();
        
        // Mark admin messages as read
        $student->messages()->where('sender', 'admin')->update(['is_read' => true]);
        
        return view('student.messages.index', compact('messages'));
    }

    public function studentStore(Request $request)
    {
        $request->validate(['message' => 'required|string']);
        $student = auth()->user()->student;

        Message::create([
            'student_id' => $student->id,
            'message' => $request->message,
            'sender' => 'student',
            'is_read' => false
        ]);

        return back()->with('success', 'Pesan terkirim.');
    }

    // Admin Side
    public function adminIndex()
    {
        // Get students who have messages, ordered by latest message
        $students = Student::whereHas('messages')
            ->withCount(['messages as unread_count' => function($query) {
                $query->where('sender', 'student')->where('is_read', false);
            }])
            ->with(['messages' => function($query) {
                $query->latest();
            }])
            ->get()
            ->sortByDesc(function($student) {
                return $student->messages->first()->created_at;
            });

        return view('admin.messages.index', compact('students'));
    }

    public function adminShow(Student $student)
    {
        $messages = $student->messages()->orderBy('created_at', 'asc')->get();
        
        // Mark student messages as read
        $student->messages()->where('sender', 'student')->update(['is_read' => true]);
        
        return view('admin.messages.show', compact('student', 'messages'));
    }

    public function adminStore(Request $request, Student $student)
    {
        $request->validate(['message' => 'required|string']);

        Message::create([
            'student_id' => $student->id,
            'message' => $request->message,
            'sender' => 'admin',
            'is_read' => false
        ]);

        return back()->with('success', 'Balasan terkirim.');
    }
}
