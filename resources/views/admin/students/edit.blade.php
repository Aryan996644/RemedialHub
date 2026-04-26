@extends('layouts.admin')
@section('title', 'Edit Student')
@section('page-title', 'Edit Student')

@section('content')
<div class="card" style="max-width:600px;">
    <div class="card-title"><i class="fas fa-user-edit" style="color:#6366f1;"></i> Edit Student</div>
    <form method="POST" action="{{ route('admin.students.update', $student->id) }}">
        @csrf @method('PUT')
        <div class="form-group">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-input" required value="{{ $student->user->name }}">
        </div>
        <div class="form-group">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-input" required value="{{ $student->user->email }}">
        </div>
        <div class="form-group">
            <label class="form-label">New Password (leave blank to keep current)</label>
            <input type="password" name="password" class="form-input" minlength="6">
        </div>
        <div class="form-group">
            <label class="form-label">Roll Number</label>
            <input type="text" name="roll_no" class="form-input" required value="{{ $student->roll_no }}">
        </div>
        <div class="form-group">
            <label class="form-label">Department</label>
            <input type="text" name="department" class="form-input" required value="{{ $student->department }}">
        </div>
        <div class="form-group">
            <label class="form-label">Semester</label>
            <select name="semester" class="form-input">
                @foreach(['1st','2nd','3rd','4th','5th','6th','7th','8th'] as $sem)
                    <option value="{{ $sem }}" {{ $student->semester == $sem ? 'selected' : '' }}>{{ $sem }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Section</label>
            <input type="text" name="section" class="form-input" value="{{ $student->section }}">
        </div>
        <div style="display:flex;gap:12px;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Student</button>
            <a href="{{ route('admin.students') }}" class="btn" style="background:#e2e8f0;color:#475569;">Cancel</a>
        </div>
    </form>
</div>
@endsection
