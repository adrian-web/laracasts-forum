@php
$body = $activity->subject->displayMentionedUsers();
@endphp

@component('user.activities.activity')

@slot('activityHeader')
<h5 class="text-gray-500">
    {{ $user->name }}
    {{ ' replied to ' }}
    <a href="{{ $activity->subject->thread->path() }}">
        {{ $activity->subject->thread->title }}
    </a>
</h5>
@endslot

@slot('activitySlot')
{{-- {{ $activity->subject->body }} --}}
{!! $body !!}
@endslot

@endcomponent