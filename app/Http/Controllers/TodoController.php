<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
class TodoController extends Controller
{
    public function index()
    {
    
        $todos = Todo::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        
        $todosCompleted = Todo::where('user_id', auth()->user()->id)
        ->where('is_complete', true)
        ->count();

        return view('todo.index', compact('todos', 'todosCompleted'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'title' => 'required',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        // Membuat todo baru
        Todo::create([
            'title' => $request->title,
            'user_id' => auth()->id(),
            'category_id' => $request->category_id ?: null,
        ]);

        return redirect()->route('todo.index');   
     }

    public function create()
    {
        $categories = Category::all();
        return view('todo.create', compact('categories'));
    }

        public function edit(Todo $todo)
    {
        // Cek apakah user yang login adalah pemilik todo
        if (auth()->id() == $todo->user_id) {
        $categories = \App\Models\Category::all(); // ambil semua kategori
        return view('todo.edit', compact('todo', 'categories'));
        } else {
            return redirect()->route('todo.index')->with('danger', 'You are not authorized to edit this todo!');
        }
    }

    public function update(Request $request, Todo $todo)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        // Update todo dengan cara yang lebih rapi
        $todo->update([
            'title' => ucfirst($request->title),
            'category_id' => $request->category_id ?: null,
        ]);

        return redirect()->route('todo.index')->with('success', 'Todo updated successfully!');
    }


    public function complete(Todo $todo)
    {
        // Memastikan hanya user yang berhak yang bisa mengubah status
        if (auth()->user()->id == $todo->user_id) {
            // Mengubah status menjadi lengkap (completed)
            $todo->update([
                'is_complete' => true,  // Pastikan menggunakan 'is_complete'
            ]);

            return redirect()->route('todo.index')->with('success', 'Todo completed successfully!');
        }

        return redirect()->route('todo.index')->with('danger', 'You are not authorized to complete this todo!');
    }

    public function uncomplete(Todo $todo)
    {
        // Memastikan hanya user yang berhak yang bisa mengubah status
        if (auth()->user()->id == $todo->user_id) {
            // Mengubah status menjadi belum lengkap (uncompleted)
            $todo->update([
                'is_complete' => false,  // Pastikan menggunakan 'is_complete'
            ]);

            return redirect()->route('todo.index')->with('success', 'Todo uncompleted successfully!');
        }

        return redirect()->route('todo.index')->with('danger', 'You are not authorized to uncomplete this todo!');
    }

        public function destroy(Todo $todo)
    {
        if (auth()->user()->id == $todo->user_id) {
            $todo->delete();
            return redirect()->route('todo.index')->with('success', 'Todo deleted successfully!');
        } else {
            return redirect()->route('todo.index')->with('danger', 'You are not authorized to delete this todo!');
        }
    }

    public function destroyCompleted()
    {
        $todosCompleted = Todo::where('user_id', auth()->user()->id)
            ->where('is_complete', true)
            ->get();

        foreach ($todosCompleted as $todo) {
            $todo->delete();
        }

        return redirect()->route('todo.index')->with('success', 'All completed todos deleted successfully!');
    }

}
