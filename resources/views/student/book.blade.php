@extends('layouts.app')

@section('title', 'Book appointment')
@section('nav-links')
    <a href="{{ route('student.dashboard') }}">Overview</a>
    <a href="{{ route('student.book') }}" class="active">Book</a>
    <a href="#">Appointments</a>
    <a href="#">Mood check-in</a>
    <a href="#">History</a>
@endsection

@section('content')
    <p class="text-uppercase text-muted" style="margin-bottom:8px;">Book Appointment</p>
    <div class="page-header">
        <div>
            <h1>Find a time that feels right.</h1>
            <p class="text-muted">Choose your counsellor, date and an available time.</p>
        </div>
        <div class="wizard-steps">
            <span class="wizard-step is-active">1</span>
            <span class="wizard-line"></span>
            <span class="wizard-step">2</span>
            <span class="wizard-line"></span>
            <span class="wizard-step">3</span>
        </div>
    </div>

    @if ($errors->any())
        <div style="color:var(--text-red); background:#fee2e2; padding:12px; border-radius:var(--radius-sm); margin-bottom:20px;">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('student.book.store') }}" method="POST" id="booking-form">
        @csrf
        <input type="hidden" name="TherapistID" id="input-therapist" value="{{ $therapist->TherapistID }}">
        <input type="hidden" name="SlotID" id="input-slot" value="">

        <div class="booking-layout">
            {{-- LEFT: counsellor + calendar + slots --}}
            <div class="booking-left">

                {{-- Counsellor picker --}}
                <div class="card card-white booking-block">
                    <h3 class="block-title">Choose a counsellor</h3>
                    <div class="counsellor-list">
                        @foreach ($therapists as $t)
                            <a href="{{ route('student.book', ['therapist_id' => $t->TherapistID, 'date' => $date->toDateString()]) }}"
                               class="counsellor-item {{ $t->TherapistID === $therapist->TherapistID ? 'is-selected' : '' }}">
                                <span class="counsellor-avatar">{{ strtoupper(substr($t->FirstName,0,1).substr($t->LastName,0,1)) }}</span>
                                <span class="counsellor-meta">
                                    <strong>{{ $t->FirstName }} {{ $t->LastName }}</strong>
                                    <small class="text-muted">{{ $t->Specialization }}</small>
                                </span>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Calendar + slots row --}}
                <div class="booking-picker">
                    <div class="card card-white booking-block">
                        <h3 class="block-title">Choose a date</h3>
                        <div class="calendar">
                            <div class="calendar-header">
                                <a href="{{ route('student.book', ['therapist_id' => $therapist->TherapistID, 'date' => $date->copy()->subMonthNoOverflow()->toDateString()]) }}">‹</a>
                                <span>{{ $date->format('F Y') }}</span>
                                <a href="{{ route('student.book', ['therapist_id' => $therapist->TherapistID, 'date' => $date->copy()->addMonthNoOverflow()->toDateString()]) }}">›</a>
                            </div>
                            <div class="calendar-grid">
                                @foreach (['Mo','Tu','We','Th','Fr','Sa','Su'] as $dow)
                                    <span class="dow">{{ $dow }}</span>
                                @endforeach
                                @php
                                    $firstOfMonth = $date->copy()->startOfMonth();
                                    $pad = $firstOfMonth->dayOfWeekIso - 1;
                                    $daysInMonth = $date->copy()->endOfMonth()->day;
                                @endphp
                                @for ($i = 0; $i < $pad; $i++)
                                    <span class="day is-empty"></span>
                                @endfor
                                @for ($d = 1; $d <= $daysInMonth; $d++)
                                    @php
                                        $dayDate = $date->copy()->day($d);
                                        $isActive = $dayDate->toDateString() === $date->toDateString();
                                        $isPast   = $dayDate->lt(now()->startOfDay());
                                    @endphp
                                    <a href="{{ route('student.book', ['therapist_id' => $therapist->TherapistID, 'date' => $dayDate->toDateString()]) }}"
                                       class="day {{ $isActive ? 'is-selected' : '' }} {{ $isPast ? 'is-disabled' : '' }}">
                                        {{ $d }}
                                    </a>
                                @endfor
                            </div>
                        </div>
                    </div>

                    <div class="card card-white booking-block">
                        <h3 class="block-title">Available times <small class="text-muted">{{ $date->format('D, j F') }}</small></h3>
                        @if ($slots->isEmpty())
                            <p class="text-muted">No slots on this date. Choose another day.</p>
                        @else
                            <div class="slot-grid">
                                @foreach ($slots as $slot)
                                    <button type="button"
                                            class="slot-btn {{ $slot->IsBooked ? 'is-booked' : '' }}"
                                            data-slot-id="{{ $slot->SlotID }}"
                                            data-slot-time="{{ \Carbon\Carbon::parse($slot->SlotTime)->format('g:i A') }}"
                                            data-slot-date="{{ $date->format('D, j F') }}"
                                            @if ($slot->IsBooked) disabled @endif>
                                        {{ \Carbon\Carbon::parse($slot->SlotTime)->format('H:i') }}
                                    </button>
                                @endforeach
                            </div>
                            <div class="slot-legend">
                                <span><span class="dot dot-available"></span> Available</span>
                                <span><span class="dot dot-selected"></span> Selected</span>
                                <span><span class="dot dot-booked"></span> Booked</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- RIGHT: summary --}}
            <aside class="booking-summary">
                <p class="text-uppercase" style="color:var(--text-light); opacity:.85;">Your appointment</p>
                <h2 class="summary-title">Almost there.</h2>

                <div class="summary-counsellor">
                    <span class="counsellor-avatar">{{ strtoupper(substr($therapist->FirstName,0,1).substr($therapist->LastName,0,1)) }}</span>
                    <div>
                        <strong>{{ $therapist->FirstName }} {{ $therapist->LastName }}</strong><br>
                        <small>{{ $therapist->Specialization }}</small>
                    </div>
                </div>

                <div class="summary-row">
                    <span>📅 Date</span>
                    <strong id="summary-date">—</strong>
                </div>
                <div class="summary-row">
                    <span>🕐 Time</span>
                    <strong id="summary-time">—</strong>
                </div>

                <p class="summary-note">🛡️ Your booking is private and confidential.</p>

                <button type="submit" class="btn-lime" id="confirm-btn" disabled style="width:100%;">
                    Confirm appointment
                </button>
            </aside>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    const slotInput    = document.getElementById('input-slot');
    const dateOut      = document.getElementById('summary-date');
    const timeOut      = document.getElementById('summary-time');
    const confirmBtn   = document.getElementById('confirm-btn');
    const slotButtons  = document.querySelectorAll('.slot-btn');

    slotButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            slotButtons.forEach(b => b.classList.remove('is-selected'));
            btn.classList.add('is-selected');
            slotInput.value = btn.dataset.slotId;
            dateOut.textContent = btn.dataset.slotDate;
            timeOut.textContent = btn.dataset.slotTime + ' · 60 mins';
            confirmBtn.disabled = false;
        });
    });
</script>
@endpush