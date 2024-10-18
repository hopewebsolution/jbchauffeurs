<div style="margin-bottom: 35px; margin-top: 35px;">
    @if ($section->section_type == 'left_section')
        <div class="row block">
            <div class="col-sm-12 col-md-6 left-side">
                <div class="text-content">
                    <h1 class="cus_h1">{{ $section->section_heading ?? '' }}</h1>
                    <div>{!! $section->section_content ?? '' !!}</div>
                    <a href="{{ $section->section_btn_link ?? '' }}"
                        class="btn btn-danger cus_btn">{{ $section->section_btn_text ?? '' }}</a>
                </div>
            </div>

            <div class="col-sm-12 col-md-6 right-side">
                <div class="image-content">
                    @if ($section->image)
                        <img src="{{ $section->image ?? '' }}" alt="Home page image">
                    @endif
                </div>
            </div>
        </div>
    @endif

    @if ($section->section_type == 'right_section')
        <div class="row block white reverse-block">
            <div class="col-sm-12 col-md-6 left-side centered">
                <div class="image-content">
                    @if ($section->image)
                        <img src="{{ $section->image ?? '' }}" alt="Home page image">
                    @endif
                </div>
            </div>

            <div class="col-sm-12 col-md-6 right-side">
                <div class="text-content">
                    <h1 class="cus_h1">{{ $section->section_heading ?? '' }}</h1>
                    <div>{!! $section->section_content ?? '' !!}</div>
                    <a href="{{ $section->section_btn_link ?? '' }}"
                        class="btn btn-danger cus_btn">{{ $section->section_btn_text ?? '' }}</a>
                </div>
            </div>
        </div>
    @endif
</div>
