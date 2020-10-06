@php
$body = $activity->subject->displayMentionedUsers();
@endphp

@component('profiles.activities.activity')

@slot('activityHeader')
{{ $user->name }}
{{ ' replied to ' }}
<a href="{{ $activity->subject->thread->path() }}">
    {{ $activity->subject->thread->title }}
</a>
@endslot

@slot('activitySlot')
{{-- {{ $activity->subject->body }} --}}
{!! $body !!}
@endslot

@endcomponent