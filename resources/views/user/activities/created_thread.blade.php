@component('user.activities.activity')

@slot('activityHeader')
<h5 class="text-gray-500">
    {{ $user->name }}
    {{ ' published ' }}
    <a href="{{ $activity->subject->path() }}">
        {{ $activity->subject->title }}
    </a>
</h5>
@endslot

@slot('activitySlot')
{{ $activity->subject->body }}
@endslot

@endcomponent