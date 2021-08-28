@extends('layouts.main_layout')

@section('content')

<div class="card user_list mt-5">
    <div class="row col-12">
        <h3 class="col-md-9 m-4">Movie Review List</h3>
        <a href="#" class="col-lg-2 col-md-4 btn btn-primary m-4 right" id="add-review"><i class="fas fa-user-plus mr-3"></i>Add Movie Review</a>
    </div>
    <table class="table m-2">
        <thead>
            <tr>
                <th>{!! $sort->getHtml('ID', 'id') !!}</th>
                <th>{!! $sort->getHtml('Poster', null) !!}</th>
                <th>{!! $sort->getHtml('Name', 'movie_name') !!}</th>
                <th>{!! $sort->getHtml('Actions', null) !!}</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($movieReviews as $movieReview)
                <tr>
                    <th>{{ $movieReview->id }}</th>
                    <td>
                        @if($movieReview->image)
                            <img class="poster_thumb movie_preview" data-id="{{ $movieReview->id }}" src='{{ $movieReview->getPoster() }}' />
                        @endif
                    </td>
                    <th>{{ $movieReview->movie_name }}</th>
                    <td>
                        <a href="#">
                            <i class="fas fa-trash mr-3 delete_movie_review" data-id="{{ $movieReview->id }}"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $movieReviews->links() }}
</div>
<div class="modal fade" id="movie-review-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Movie Review Form
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="movie-review-form" href="someplace.php">
                <div class="modal-body p-4">
                    <div class="form-group row">
                        <label for="name" class="col-sm-3">Movie Name</label>
                        <input id="name" name="movie_name" type="text" class="form-control col-md-9"/>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-3">Poster</label>
                        <input id="poster" name="movie_poster" type="file" class="form-control col-md-9"/>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-3">Review Date</label>
                        <input id="review-date" name="review_date" type="date" class="form-control col-md-9"/>
                    </div>
                    <div class="form-group row">
                        <label for="name" class="col-sm-3">Rating</label>
                        <input id="rating" name="movie_rating" type="number" min="0" max="5" class="form-control col-md-9"/>
                    </div>
                    <div class="form-group row">
                        <label for="review" class="col-sm-3">Review</label>
                        <div class="form-line col-sm-9" style="padding: 0px">
                            <textarea name="review" id="review" cols="35" rows="4" class="form-control no-resize"></textarea>                        
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="sumbit" id="save-review" class="btn btn-info waves-effect">Save</button>
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="movie-preview-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Movie Review</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body p-4 col-12 row">
                <div class="col-lg-4 col-md-6">
                    <img class="poster_preview" id="pre-movie-img" src='' />
                </div>
                <div class="col-lg-8 col-md-6">
                    <span>Movie name : </span><span id="pre-movie-name"></span><br><br>
                    <span>Rating : </span><span id="pre-movie-rating"></span><br><br>
                    <span>Movie review : </span><span id="pre-movie-review"></span><br><br>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                Are you sure?
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-danger" id="delete">Delete</button>
                <button type="button" data-dismiss="modal" class="btn">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
    
    $(document).ready(function() {
        $('#add-review').click(function () {
            $('#movie-review-modal').modal('show');
        });

        $('#movie-review-form').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            formData.append('_token', '{{ csrf_token() }}');
            console.log(formData);
            $.ajax({
                type: "POST",
                url: "{{ route('movie_review.create') }}",
                processData: false,
                contentType: false,
                data: formData,
                success: function(response) {
                    console.log(response);
                    if (response.status) {
                        location.reload();
                    }
                }
            });
        });

        $('.movie_preview').on('click', function () {
            var url = "{{ route('movie_review.get', ":id") }}";
            url = url.replace(':id', $(this).data('id'));
            $.ajax({
                type: "GET",
                url: url,
                success: function(response) {
                    $('#movie-preview-modal').modal('show');
                    $('#pre-movie-name').html(response.data.movie_name);
                    $('#pre-movie-rating').html(response.data.rating);
                    $('#pre-movie-review').html(response.data.review);
                    $('#pre-movie-img').attr('src',response.data.poster_url);
                }
            });
        });

        $('.delete_movie_review').on('click', function (e) {
            Swal.fire({
                title: 'Do you want to delete this review?',
                showCancelButton: true,
                confirmButtonText: 'Yes',
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ route('movie_review.delete', ":id") }}";
                    url = url.replace(':id', $(this).data('id'));
                    $.ajax({
                        type: "DELETE",
                        url: url,
                        data: {
                            '_token' : '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status) {
                                Swal.fire('Review deleted', '', 'danger')
                                location.reload();
                            }
                        }
                    });
                }
            });
        });

    });
</script>
@endsection