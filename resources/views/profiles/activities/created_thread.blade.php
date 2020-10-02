@component('profiles.activities.activity')

@slot('activityHeader')
{{ $user->name }}
{{ ' published ' }}
<a href="{{ $activity->subject->path() }}">
    {{ $activity->subject->title }}
</a>
@endslot

@slot('activitySlot')
{{ $activity->subject->body }}
@endslot

@endcomponent