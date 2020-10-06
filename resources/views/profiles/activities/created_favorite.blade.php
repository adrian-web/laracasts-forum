@php
$body = $activity->subject->favorited->displayMentionedUsers();
@endphp

@component('profiles.activities.activity')

@slot('activityHeader')
{{ $user->name }}
{{ ' favorited a ' }}
<a href="{{ $activity->subject->favorited->path() }}">
    reply
</a>
@endslot

@slot('activitySlot')
{{-- {{ $activity->subject->favorited->body }} --}}
{!! $body !!}
@endslot

@endcomponent