@extends((( Auth::user()->role->name == 'ROLE_ADMIN') ? 'layouts.administrator' : 'layouts.teacher' ))

@section('content')

<div class="container">

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div id="form"></div>

    <div class="row">


        <div  class="col-md-4" style="padding: 0px; margin: 0px;">
            <input type="text" class="form-control" id="myInputCollage" style="margin: 10px;"
            onkeyup="FiltrarCollage()"  placeholder="Scoil Cuardaigh...">

            <input type="text" class="form-control" id="myInputForms" style="margin: 10px;"
            onkeyup="FiltrarFormName()" placeholder="Form Cuardaigh...">
        </div>


        <script type="application/javascript">
    function FiltrarCollage(){ //search just for the name of the college
        var value01 = $('#myInputCollage').val().toLowerCase();
        $(".SchoolName").filter(function() {
            $(this).parent().parent().toggle($(this).text().toLowerCase().indexOf(value01) > -1)
        });

        var value02 = $('#myInputForms').val().toLowerCase();
        $(".TemplateName:visible").filter(function() {
            $(this).parent().parent().toggle($(this).text().toLowerCase().indexOf(value02) > -1tea)
        });
    }
    ///////////////////////////////////////////
    ///////////////////////////////////////////
    ///////////////////////////////////////////
    function FiltrarFormName(){ //search just for the name of the college
        var value01 = $('#myInputCollage').val().toLowerCase();
        $(".SchoolName:visible").filter(function() {
            $(this).parent().parent().toggle($(this).text().toLowerCase().indexOf(value01) > -1)
        });

        var value02 = $('#myInputForms').val().toLowerCase();
        $("TemplateName").filter(function() {
            $(this).parent().parent().toggle($(this).text().toLowerCase().indexOf(value02) > -1)
        });
    }


        </script>

        <div class="col-md-4">




          <div id="list_chat" class="list-group" style="height: 600px; overflow-y: scroll;">

            @foreach($headers as $header)

              @if(Auth::user()->role->name == 'ROLE_TEACHER')
                @if(!empty($header->comments->last()->state))
                <a id="item{{$header->id}}" href="#" onclick="recover_conversation('{{$header->id}}')" class="list-group-item list-group-item-action flex-column align-items-start">
                  <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1 SchoolName">{{$header->title}}</h5>
                    <small class="TemplateName">{{$header->template->name}}</small>
                  </div>
                  <p class="mb-1">{{$header->comments->last()->text}}</p>
                  <small></small>
                </a>
                @endif
              @endif


              @if(Auth::user()->role->name == 'ROLE_ADMIN')
                @if(!empty($header->comments->last()->state))
                <a id="item{{$header->id}}" href="#" onclick="recover_conversation('{{$header->id}}')" class="list-group-item list-group-item-action flex-column align-items-start">
                  <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1 SchoolName">{{$header->teacher->school->name}}</h5>
                    <small class="TemplateName">{{$header->template->name}}</small>
                  </div>
                  <p class="mb-1">{{$header->comments->last()->text}}</p>
                  <small></small>
                </a>
                @endif
              @endif



            @endforeach
          </div>
         </div>

        <div class="col-md-6">
          <div id="chat"></div>
        </div>

    </div>

    <script type="application/javascript">

      var header_id;

      function recover_conversation(id){
        $('#item'+header_id).removeClass('active');
        $('#item'+id).addClass('active');
        header_id = id;
        var ruta = '{{route('comment.recover',':id')}}';
        ruta = ruta.replace(':id', header_id);

        $.ajax({
            url: ruta,
            type:"GET",
            success:function(resp){
              $('#chat').html(resp);
              $("#conversation").animate({ scrollTop: $('#conversation').prop("scrollHeight")}, 2000);
            }
        });
      }




      /*
    function FiltrarCollage(){ //search just for the name of the college
        var value01 = $('#myInputCollage').val().toLowerCase();
        $("#list_chat a .SchoolName").filter(function() {
            $(this).parent().parent().toggle($(this).text().toLowerCase().indexOf(value01) > -1)
        });

        var value02 = $('#myInputForms').val().toLowerCase();
        $("#list_chat a .TemplateName").filter(function() {
            $(this).parent().parent().toggle($(this).text().toLowerCase().indexOf(value02) > -1)
        });
    }
    */
    /*
    function FiltrarFormName(){ //search just for the name of the college
        var value01 = $('#myInputCollage').val().toLowerCase();
        $("#list_chat a .SchoolName").filter(function() {
            $(this).parent().parent().toggle($(this).text().toLowerCase().indexOf(value01) > -1)
        });

        var value02 = $('#myInputForms').val().toLowerCase();
        $("#list_chat a .TemplateName").filter(function() {
            $(this).parent().parent().toggle($(this).text().toLowerCase().indexOf(value02) > -1)
        });
    }
    */
    </script>

@endsection
