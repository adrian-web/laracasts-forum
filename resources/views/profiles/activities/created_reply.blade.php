@php
$body = $activity->subject->displayMentionedUsers();
@endphp

@component('profiles.activities.activity')

@slot('activityHeader')
<img class="h-8 w-8 rounded-full object-cover" src="{{ $user->profile_photo_url }}" alt="{{ $user->username }}" />
<h4 class="ml-3 text-xl text-gray-500">
    {{ $user->name }}
    {{ ' replied to ' }}
    <a href="{{ $activity->subject->thread->path() }}">
        {{ $activity->subject->thread->title }}
    </a>
</h4>
@endslot

@slot('activitySlot')
{{-- {{ $activity->subject->body }} --}}
{!! $body !!}
@endslot

@endcomponent