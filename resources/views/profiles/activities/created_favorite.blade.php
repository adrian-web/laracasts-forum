@component('profiles.activities.activity')

@slot('activityHeader')
{{ $profileUser->name }}
{{ ' favorited a ' }}
<a href="{{ $activity->subject->favorited->path() }}">
    reply
</a>
@endslot

@slot('activitySlot')
{{ $activity->subject->favorited->body }}
@endslot

@endcomponent