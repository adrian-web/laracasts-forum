@php
$body = $activity->subject->favorited->displayMentionedUsers();
@endphp

@component('user.activities.activity')

@slot('activityHeader')
<img class="h-8 w-8 rounded-full object-cover" src="{{ $user->profile_photo_url }}" alt="{{ $user->username }}" />
<h4 class="ml-3 text-xl text-gray-500">
    {{ $user->name }}
    {{ ' favorited a ' }}
    <a href="{{ $activity->subject->favorited->path() }}">
        {{ __('reply') }}
    </a>
</h4>
@endslot

@slot('activitySlot')
{{-- {{ $activity->subject->favorited->body }} --}}
{!! $body !!}
@endslot

@endcomponent