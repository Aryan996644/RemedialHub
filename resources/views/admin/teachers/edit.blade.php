@extends('layouts.admin')
@section('title', 'Edit Teacher')
@section('page-title', 'Edit Teacher')

@section('content')
<div class="card" style="max-width:600px;">
    <div class="card-title"><i class="fas fa-user-edit" style="color:#6366f1;"></i> Edit Teacher</div>
    <form method="POST" action="{{ route('admin.teachers.update', $teacher->id) }}">
        @csrf @method('PUT')
        <div class="form-group">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-input" required value="{{ $teacher->user->name }}">
        </div>
        <div class="form-group">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-input" required value="{{ $teacher->user->email }}">
        </div>
        <div class="form-group">
            <label class="form-label">Password (leave blank to keep current)</label>
            <input type="password" name="password" class="form-input" minlength="6">
        </div>
        <div class="form-group">
            <label class="form-label">Employee ID</label>
            <input type="text" name="employee_id" class="form-input" required value="{{ $teacher->employee_id }}">
        </div>
        <div class="form-group">
            <label class="form-label">Department</label>
            <input type="text" name="department" class="form-input" required value="{{ $teacher->department }}">
        </div>
        <div class="form-group">
            <label class="form-label">Subject</label>
            <input type="text" name="subject" class="form-input" required value="{{ $teacher->subject }}">
        </div>
        <div style="display:flex;gap:12px;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Teacher</button>
            <a href="{{ route('admin.teachers') }}" class="btn" style="background:#e2e8f0;color:#475569;">Cancel</a>
        </div>
    </form>
</div>
@endsection
