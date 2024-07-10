@extends('layouts.app')
@section('css')

<link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection
@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <section>
                    <div class="container py-5">

                        <div class="row d-flex justify-content-center">
                            <div class="col-md-8 col-lg-6 col-xl-4">

                                <div class="card header-color" id="chat1" style="border-radius: 15px;">
                                    <div class="card-header d-flex justify-content-between align-items-center p-3 bg-info text-white border-bottom-0"
                                        style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
                                        <i class="fas fa-angle-left"></i>
                                        <p class="mb-0 fw-bold">Live chat</p>
                                        <i class="fas fa-times"></i>
                                    </div>
                                    <div class="card-body">

                                        <div class="chat-div">

                                        </div>




                                        <input type="hidden" id="recever_id" name="recever_id" value="2">
                                        <div data-mdb-input-init class="form-outline">
                                            <textarea class="form-control bg-body-tertiary" id="message" rows="4"
                                                placeholder="Type your message"></textarea>
                                            <div class="mt-2" style="text-align: right">
                                                <button class="btn btn-info btn-sm text-white btn-color"
                                                    id="sendBtn">Send</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </section>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
@vite('resources/js/app.js')

<script type="module">
    Echo.channel(`chat-room`)
    .listen('MessageSent', (e) => {
    console.log(e.message);
    });
</script>

<script>
    $(document).ready(function(){
            // Set up CSRF token for all AJAX requests
            $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

            $('#sendBtn').click(function(){
                let message = $('#message').val();
               let recever_id = $('#recever_id').val();
               
                $.ajax({
                    url: "{{ route('send-message') }}", // Replace with your server endpoint
                    method: 'POST', // or 'GET' depending on your needs
                    data: { message, recever_id},
                    success: function(response) {
                        console.log(response);
                        // alert('Success: ' + response.message);
                    },
                    error: function(xhr, status, error) {
                        alert('Error: ' + xhr.responseText);
                    }
                });
            });
        });
</script>
@endsection