@extends('layouts.admin')
@section('title', 'Add Student')
@section('page-title', 'Add New Student')

@section('content')
<div class="card" style="max-width:600px;">
    <div class="card-title"><i class="fas fa-user-plus" style="color:#6366f1;"></i> Add Student</div>
    <form method="POST" action="{{ route('admin.students.store') }}">
        @csrf
        <div class="form-group">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-input" required value="{{ old('name') }}">
        </div>
        <div class="form-group">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-input" required value="{{ old('email') }}">
        </div>
        <div class="form-group">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-input" required minlength="6">
        </div>
        <div class="form-group">
            <label class="form-label">Roll Number</label>
            <input type="text" name="roll_no" class="form-input" required value="{{ old('roll_no') }}">
        </div>
        <div class="form-group">
            <label class="form-label">Department</label>
            <input type="text" name="department" class="form-input" required value="{{ old('department') }}">
        </div>
        <div class="form-group">
            <label class="form-label">Semester</label>
            <select name="semester" class="form-input">
                @foreach(['1st','2nd','3rd','4th','5th','6th','7th','8th'] as $sem)
                    <option value="{{ $sem }}" {{ old('semester') == $sem ? 'selected' : '' }}>{{ $sem }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Section (Optional)</label>
            <input type="text" name="section" class="form-input" value="{{ old('section') }}">
        </div>
        <div style="display:flex;gap:12px;">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Student</button>
            <a href="{{ route('admin.students') }}" class="btn" style="background:#e2e8f0;color:#475569;">Cancel</a>
        </div>
    </form>
</div>
@endsection
