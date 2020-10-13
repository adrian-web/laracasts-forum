@php
$body = $activity->subject->favorited->displayMentionedUsers();
@endphp

@component('user.activities.activity')

@slot('activityHeader')
<h5 class="text-gray-500">
    {{ $user->name }}
    {{ ' favorited a ' }}
    <a href="{{ $activity->subject->favorited->path() }}">
        {{ __('reply') }}
    </a>
</h5>
@endslot

@slot('activitySlot')
{{-- {{ $activity->subject->favorited->body }} --}}
{!! $body !!}
@endslot

@endcomponent