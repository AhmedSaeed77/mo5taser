@extends('site.includes.master')

@section('content')

<section class="pdf-page body-inner">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="solid-container"></div>
                
                <div class="btn-center">
                    <a href="{{ route('site.course-units',$content->course_id) }}" class="btn">
                        <span> @lang('lang.back_to_course') </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection

@section('js')

<script type="text/javascript">
    $(document).ready(function() {

      $('.solid-container').wowBook({
         height   : 1024
        ,width    : 725*2
        // ,maxWidth : 800
        // ,maxHeight : 400
        ,pageNumbers: false,
        pdf: "{{asset($content->attachement)}}",
        pdfFind: true
        ,pdfTextSelectable: true

        // ,lightbox : "#book2-trigger"
        // ,lightboxClass : "lightbox-pdf"
        ,centeredWhenClosed : true
        ,hardcovers : true
        ,curl: false
        ,toolbar: "left, currentPage, right, fullscreen"
        ,responsiveHandleWidth : 50,
        responsiveToolbar: true,
        flipSound: false,
        responsiveSinglePage: true,
        singlePage: true,
      });
    });
</script>

@endsection
