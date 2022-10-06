<section style="background-color: #eee;" wire:poll="refreshMessages">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0">
                <div class="row">
                    @if (count($chats) > 0)
                        <div class="col-md-12">
                            <h5 class="font-weight-bold mb-3 text-center text-lg-start">Chats</h5>

                            <div class="card">
                                <div class="card-body">
                                    <ul class="list-unstyled mb-0">
                                        @foreach ($chats as $chat)
                                            <li class="p-2 border-bottom" style="background-color: #eee;">
                                                <a href="#!"
                                                    class="d-flex justify-content-between {{ $chat->id == $activeChat->id ? 'text-success' : '' }}"
                                                    wire:click="navigationChatClicked('{{ $chat->id }}')">
                                                    <div class="d-flex flex-row">
                                                        <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-8.webp"
                                                            alt="avatar"
                                                            class="rounded-circle d-flex align-self-center me-3 shadow-1-strong"
                                                            width="60">
                                                        <div class="pt-1">
                                                            <p class="fw-bold mb-0">
                                                                @if ($chat->isGroupChat())
                                                                    <!-- Is group chat -->
                                                                    {{ $chat->name }}
                                                                @else
                                                                    <!-- Is not group chat -->
                                                                    @foreach ($chat->users()->where('users.id', '<>', Auth::user()->id)->get() as $user)
                                                                        {{ $user->name }}
                                                                    @endforeach
                                                                @endif
                                                            </p>
                                                            <p class="small text-muted">
                                                                {{-- Hello, Are you there? --}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="pt-1">
                                                        <p class="small text-muted mb-1">
                                                            {{-- Just now --}}
                                                        </p>
                                                        <span class="badge bg-danger float-end">
                                                            {{-- 1 --}}
                                                        </span>
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="col-md-12">
                        <h5 class="font-weight-bold mb-3 text-center text-lg-start">Users</h5>

                        <div class="card">
                            <div class="card-body">
                                <ul class="list-unstyled mb-0">
                                    @foreach ($users as $user)
                                        <li class="p-2 border-bottom" style="background-color: #eee;">
                                            <a href="#!" class="d-flex justify-content-between">
                                                <div class="d-flex flex-row">
                                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-8.webp"
                                                        alt="avatar"
                                                        class="rounded-circle d-flex align-self-center me-3 shadow-1-strong"
                                                        width="60">
                                                    <div class="pt-1">
                                                        <p class="fw-bold mb-0">
                                                            {{ $user->name }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="pt-1">
                                                    <p class="small text-muted mb-1">
                                                        {{-- Just now --}}
                                                    </p>
                                                    <span class="badge bg-danger float-end">
                                                        {{-- 1 --}}
                                                    </span>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (!is_null($activeChat))
                <div class="col-md-6 col-lg-7 col-xl-8">
                    <ul class="list-unstyled">
                        @foreach ($activeChat->messages->sortBy('created_at') as $message)
                            <!-- Authenticated users messages -->
                            @if ($message->isAuthenticatedUsers())
                                <li class="d-flex justify-content-between mb-4">
                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-6.webp" alt="avatar"
                                        class="rounded-circle d-flex align-self-start me-3 shadow-1-strong"
                                        width="60">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between p-3">
                                            <p class="fw-bold mb-0">
                                                {{ $message->user->name }}
                                            </p>

                                            <p class="text-muted small mb-0">
                                                <i class="far fa-clock"></i> {{ $message->getReadableCreatedAt() }}
                                            </p>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-0">
                                                {{ $message->message }}
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            @else
                                <!-- Unauthenticated / Other users messages. -->
                                <li class="d-flex justify-content-between mb-4">
                                    <div class="card w-100">
                                        <div class="card-header d-flex justify-content-between p-3">
                                            <p class="fw-bold mb-0">
                                                {{ $message->user->name }}
                                            </p>

                                            <p class="text-muted small mb-0">
                                                <i class="far fa-clock"></i> {{ $message->getReadableCreatedAt() }}
                                            </p>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-0">
                                                {{ $message->message }}
                                            </p>
                                        </div>
                                    </div>
                                    <img src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/avatar-5.webp" alt="avatar"
                                        class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong"
                                        width="60">
                                </li>
                            @endif
                        @endforeach

                        <form wire:submit.prevent="sendMessage">
                            <li class="bg-white mb-3">
                                <div class="form-outline">
                                    <textarea class="form-control" id="textAreaExample2" rows="4" wire:model="message"></textarea>
                                    <label class="form-label" for="textAreaExample2">Message</label>
                                </div>
                            </li>
                            <button type="submit" class="btn btn-info btn-rounded float-end">Send</button>
                        </form>
                    </ul>
                </div>
            @endif
        </div>
    </div>
</section>
