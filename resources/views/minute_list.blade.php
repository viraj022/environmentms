@extends('layouts.admin')
@extends('layouts.styles')
@extends('layouts.scripts')
@section('content')
<section class="content-header">
    <div class="col-md-12">
        <div class="card card-widget">
            <div class="card-header">
              <b class="username">Minutes List</b>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-primary" onClick="window.print()">Print</button>
              </div>
            </div>
            <div class="card-footer card-comments" style="display: block;">
                @if($minute_lists)
                    @foreach($minute_lists as $minute_list)
                    <div class="card-comment">
                        <img class="img-circle img-sm" src="../../dist/img/user1-128x128.jpg" alt="User Image">
                        <div class="comment-text">
                          <span class="username"> 
                            {{$minute_list['situation']}}
                            <span class="text-muted float-right">{{$minute_list['updated_at']}}</span>
                          </span>
                          {{$minute_list['minute_description']}}
                          </br>
                          Officer:{{$minute_list['user']}}
                        </div>
                      </div>
                    @endforeach
                @else
                   <td>No Data Found</td>
                @endif 
            </div> 
        </div>
    </div>
</section>
@endsection

