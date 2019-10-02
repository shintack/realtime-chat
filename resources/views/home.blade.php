@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div>
  <b-tabs content-class="mt-3" fill>
    <b-tab title="First" active><p>I'm the first tab</p></b-tab>
    <b-tab title="Second"><p>I'm the second tab</p></b-tab>
    <b-tab title="Very, very long title"><p>I'm the tab with the very, very long title</p></b-tab>
    <b-tab title="Disabled" disabled><p>I'm a disabled tab!</p></b-tab>
  </b-tabs>
</div>
            <nav>
                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true"> <i class="fa fa-history"></i> History</a>
                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-chat" role="tab" aria-controls="nav-profile" aria-selected="false"> <i class="fa fa-comments"></i> Chat</a>
                    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact" role="tab" aria-controls="nav-contact" aria-selected="false"> <i class="fa fa-address-book"></i> Contact</a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">...</div>
                <div class="tab-pane fade" id="nav-chat" role="tabpanel" aria-labelledby="nav-profile-tab">...</div>
                <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...</div>
            </div>
            <div class="card">
                <div class="card-header"> Dashboard</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-2 ml-auto d-flex align-items-center" @click="openChat(channel.id)">
                            <img
                            width="100%"
                            height="100%"
                            src="data:image/png;base64,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"
                            alt
                            />
                        </div>
                        <div class="col">
                            <div
                                class="contact-name"
                                @click="openChat(channel.id)"
                                >username
                            </div>
                            <small class="online-status">
                            <i>Offline | 3 jam lalu Name</i>
                            </small>
                        </div>
                        <div class="col-2 text-right">
                            <button class="btn btn-sm btn-warning" @click="deleteChanel(channel.id)">del</button>
                        </div>
                    </div>
                    <ul class="list-contact table-hover">
                        <li class="p-2 contact">
                            <div class="row">
                                <div class="col-1" @click="openChat(channel.id)">
                                    <img
                                    class
                                    src="data:image/png;base64,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"
                                    alt
                                    />
                                </div>
                                <div class="col">
                                <div
                                    class="contact-name"
                                    @click="openChat(channel.id)"
                                    >username</div>
                                    <small class="online-status">
                                    <i>Offline | 3 jam lalu Name</i>
                                    </small>
                                </div>
                                <div class="col-1">
                                    <button class="btn btn-sm btn-warning" @click="deleteChanel(channel.id)">del</button>
                                </div>
                            </div>
                        </li>
                    </ul>

                    <hr>

                    <ul class="list-contact table-hover">
                        <li class="p-2 contact">
                            <div class="row ">
                                <div class="col-2">
                                    <img class="" src="data:image/png;base64,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" alt="">
                                </div>
                                <div class="col">
                                    <div>  a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it </div>
                                    <small class="online-status"><i> Offline | 3 jam lalu Name </i></small>
                                </div>
                            </div>
                        </li>
                        <li class="p-2 contact">
                            <div class="row text-right">
                                <div class="col">
                                    <div>  a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it </div>
                                    <small class="online-status"><i> Offline | 3 jam lalu Name </i></small>
                                </div>
                                <div class="col-2">
                                    <img class="" src="data:image/png;base64,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" alt="">
                                </div>
                            </div>
                        </li>

                    </ul>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('style')
    {{-- <style>
        .list-contact{
            list-style: none;
        }
        .contact{
        }
        .contact:hover{
            background-color: #ffff99;
            cursor: pointer;
        }
        .contact-name{
            font-weight: bold;
            font-size: 1.5em;
        }
        .list-contact li{
            margin-left: -40px;
            height: 65px;
        }
        .list-contact li img{
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }
    </style> --}}
@endsection
