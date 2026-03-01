@extends('layouts/contentNavbarLayout')

@section('title', isset($question) ? 'Edit Question' : 'Add Question')
@section('page-script')
    <script src="{{ asset('assets/js/pages-account-settings-account.js') }}"></script>
@endsection
@section('content')
    <style>
        .btn-info, .btn-danger, .btn-success { width: fit-content; height: 30px; }
        .col-sm-2 { width: 100%; text-align: left; margin: 5px 10px; }
        .h6 { padding: 0px 5px; }
        .option-thumb { max-width: 60px; max-height: 50px; object-fit: cover; border-radius: 4px; }
        .option-row { border: 1px solid #eee; padding: 10px; margin-bottom: 8px; border-radius: 4px; }
    </style>

    <div class="row">
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-lg-9 border p-2">
                            <span class="w-100 d-block p-1 fw-bold text-dark" style="background: #e5e5e5;">
                                {{ isset($question) ? 'Edit Question' : 'Add Question' }} — {{ $quizMaster->name }}
                                <span class="float-end">
                                    <a href="{{ route('quiz-master.questions', $quizMaster->id) }}" class="btn btn-md btn-success">Back to Questions</a>
                                </span>
                            </span>

                            @if(isset($question))
                                <form action="{{ route('quiz-master.question.update', [$quizMaster->id, $question->id]) }}" method="post" enctype="multipart/form-data" id="questionForm">
                            @else
                                <form action="{{ route('quiz-master.question.store', $quizMaster->id) }}" method="post" enctype="multipart/form-data" id="questionForm">
                            @endif
                                @csrf
                                <div class="row mt-3">
                                    <div class="col-sm-12">
                                        <label class="fw-bold">Question Image <span class="text-danger">*</span></label>
                                        <p class="text-muted small">Main image shown for this question (e.g. single object from memory page).</p>
                                        @if(isset($question) && $question->question_image)
                                            <div class="mb-2">
                                                <img src="{{ asset($question->question_image) }}" alt="" class="option-thumb">
                                                <span class="text-muted ms-2">Current</span>
                                            </div>
                                        @endif
                                        <input type="file" class="form-control" name="question_image" accept="image/*" {{ isset($question) ? '' : 'required' }}>
                                    </div>
                                    <div class="col-sm-12 mt-3">
                                        <label class="fw-bold">Answer Image (optional)</label>
                                        <p class="text-muted small">Image shown when revealing the correct answer.</p>
                                        @if(isset($question) && $question->answer_image)
                                            <div class="mb-2">
                                                <img src="{{ asset($question->answer_image) }}" alt="" class="option-thumb">
                                                <span class="text-muted ms-2">Current</span>
                                            </div>
                                        @endif
                                        <input type="file" class="form-control" name="answer_image" accept="image/*">
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <label class="fw-bold">Answer Options (add more or delete one)</label>
                                    <p class="text-muted small">Upload an image for each option (A, B, C, D…). Select the correct answer.</p>
                                    <div id="optionsContainer">
                                        @if(isset($question) && $question->options->count() > 0)
                                            @foreach($question->options as $idx => $opt)
                                            <div class="option-row" data-index="{{ $idx }}">
                                                <div class="d-flex align-items-center flex-wrap gap-2">
                                                    <span class="fw-bold option-label">{{ chr(65 + $idx) }}</span>
                                                    <input type="hidden" name="options[{{ $idx }}][id]" value="{{ $opt->id }}">
                                                    @if($opt->image)
                                                        <img src="{{ asset($opt->image) }}" alt="" class="option-thumb">
                                                    @endif
                                                    <input type="file" class="form-control form-control-sm" name="options[{{ $idx }}][image]" accept="image/*" style="max-width: 200px;">
                                                    <label class="mb-0 me-2">
                                                        <input type="radio" name="correct_option_index" value="{{ $idx }}" {{ $question->correct_option_id == $opt->id ? 'checked' : '' }}>
                                                        Correct
                                                    </label>
                                                    <button type="button" class="btn btn-sm btn-outline-danger remove-option">Remove</button>
                                                </div>
                                            </div>
                                            @endforeach
                                        @else
                                            <div class="option-row" data-index="0">
                                                <div class="d-flex align-items-center flex-wrap gap-2">
                                                    <span class="fw-bold option-label">A</span>
                                                    <input type="file" class="form-control form-control-sm" name="options[0][image]" accept="image/*" style="max-width: 200px;" required>
                                                    <label class="mb-0 me-2"><input type="radio" name="correct_option_index" value="0"> Correct</label>
                                                    <button type="button" class="btn btn-sm btn-outline-danger remove-option">Remove</button>
                                                </div>
                                            </div>
                                            <div class="option-row" data-index="1">
                                                <div class="d-flex align-items-center flex-wrap gap-2">
                                                    <span class="fw-bold option-label">B</span>
                                                    <input type="file" class="form-control form-control-sm" name="options[1][image]" accept="image/*" style="max-width: 200px;" required>
                                                    <label class="mb-0 me-2"><input type="radio" name="correct_option_index" value="1"> Correct</label>
                                                    <button type="button" class="btn btn-sm btn-outline-danger remove-option">Remove</button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="addOption">+ Add option</button>
                                </div>

                                <div class="row justify-content-end mt-4">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-md btn-primary">{{ isset($question) ? 'Update' : 'Save' }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg-3">
                            @include('layouts/sections/menu/verticalRightMenu')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script>
    $(function(){
        var optionIndex = $('#optionsContainer .option-row').length;
        var labels = ['A','B','C','D','E','F','G','H','I','J'];

        function reindexOptions() {
            $('#optionsContainer .option-row').each(function(i){
                $(this).attr('data-index', i);
                $(this).find('.option-label').text(labels[i]);
                $(this).find('input[type="file"]').attr('name', 'options[' + i + '][image]');
                $(this).find('input[type="hidden"]').attr('name', 'options[' + i + '][id]');
                $(this).find('input[type="radio"]').attr('value', i);
            });
            optionIndex = $('#optionsContainer .option-row').length;
        }

        $('#addOption').on('click', function(){
            var row = '<div class="option-row" data-index="' + optionIndex + '">' +
                '<div class="d-flex align-items-center flex-wrap gap-2">' +
                '<span class="fw-bold option-label">' + (labels[optionIndex] || (optionIndex+1)) + '</span>' +
                '<input type="file" class="form-control form-control-sm" name="options[' + optionIndex + '][image]" accept="image/*" style="max-width: 200px;">' +
                '<label class="mb-0 me-2"><input type="radio" name="correct_option_index" value="' + optionIndex + '"> Correct</label>' +
                '<button type="button" class="btn btn-sm btn-outline-danger remove-option">Remove</button>' +
                '</div></div>';
            $('#optionsContainer').append(row);
            optionIndex++;
            reindexOptions();
        });

        $('#optionsContainer').on('click', '.remove-option', function(){
            if ($('#optionsContainer .option-row').length <= 2) {
                alert('Keep at least 2 options.');
                return;
            }
            $(this).closest('.option-row').remove();
            reindexOptions();
        });
    });
    </script>
@endsection
