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

                                        {{-- will append vai jquery --}}
                                        <div id="chat-container">
                                            <!-- Messages will be appended here -->
                                        </div>

                                        <input type="hidden" id="receiver_id" name="receiver_id" value="1">
                                        <div data-mdb-input-init class="form-outline">
                                            <textarea class="form-control bg-body-tertiary" name="message" id="message"
                                                rows="4" placeholder="Type your message"></textarea>
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
    //     Echo.channel(`chat-room`)
//     .listen('MessageSent', (e) => {
//    console.log(e.message,'msg');
//         if(e.message != null){
        
//         }
       
   
//     });
Echo.channel('chat-room')
.listen('MessageSent', (e) => {
console.log(e.message, 'msg');
if (e.message != null) {

  let userId = "{{ auth()->id() }}";
    if (e.message.sender_id == userId) {
    $('#chat-container').append(`
  <div class="d-flex flex-row justify-content-start mb-4">
    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp" alt="avatar 1"
        style="width: 45px; height: 100%;">
    <div class="p-3 ms-3" style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
        <p class="small mb-0">${e.message.message}.</p>
    </div>
</div>
    `);
    } else if (e.message.receiver_id == userId) {
    $('#chat-container').append(`
   <div class="d-flex flex-row justify-content-end mb-4">
    <div class="p-3 me-3 border bg-body-tertiary" style="border-radius: 15px;">
        <p class="small mb-0">${e.message.message}.</p>
    </div>
    <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava2-bg.webp" alt="avatar 1"
        style="width: 45px; height: 100%;">
</div>
    `);
    }






   
}
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
               let receiver_id = $('#receiver_id').val();
               
                $.ajax({
                    url: "{{ route('send-message') }}", // Replace with your server endpoint
                    method: 'POST', // or 'GET' depending on your needs
                    data: { message, receiver_id},
                    success: function(response) {
                        console.log(response);
                        // Clear the input field
                        $('#message').val('');
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