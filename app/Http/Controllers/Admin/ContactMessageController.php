<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ContactMessageController extends Controller
{
    public function index(Request $request): Response
    {
        $query = ContactMessage::query();

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $messages = $query->orderByDesc('created_at')->paginate(15)->withQueryString();

        return Inertia::render('admin/messages/Index', [
            'messages' => $messages,
            'filters' => $request->only(['status']),
        ]);
    }

    public function show(ContactMessage $message): Response
    {
        if ($message->status === 'unread') {
            $message->update(['status' => 'read']);
        }

        return Inertia::render('admin/messages/Show', [
            'message' => $message,
        ]);
    }

    public function destroy(ContactMessage $message): RedirectResponse
    {
        $message->delete();

        return redirect()->route('admin.messages.index')->with('success', 'Message deleted.');
    }
}
