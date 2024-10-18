<div style="margin-bottom: 35px; margin-top: 35px;">
    @if ($section->section_type == 'left_section')
        <div class="row block cus_row_block">
            <div class="col-sm-12 col-md-6 left-side">
                <div class="text-content">
                    @if (isset($section->section_heading))
                        <h1 class="cus_h1 sec_title">{{ $section->section_heading ?? '' }}</h1>
                    @endif
                    <div>{!! $section->section_content ?? '' !!}</div>
                    @if (isset($section->section_btn_text))
                        <a href="{{ $section->section_btn_link ?? '' }}"
                            class="btn btn-danger cus_btn join_btn">{{ $section->section_btn_text ?? '' }}</a>
                    @endif
                </div>
            </div>

            <div class="col-sm-12 col-md-6 right-side">
                <div class="image-content">
                    @if ($section->image)
                        <img src="{{ $section->image ?? '' }}" alt="JBChauffeurs">
                    @endif
                </div>
            </div>
        </div>
    @endif

    @if ($section->section_type == 'right_section')
        <div class="row block cus_row_block white reverse-block">
            <div class="col-sm-12 col-md-6 left-side centered">
                <div class="image-content">
                    @if ($section->image)
                        <img src="{{ $section->image ?? '' }}" alt="JBChauffeurs">
                    @endif
                </div>
            </div>

            <div class="col-sm-12 col-md-6 right-side">
                <div class="text-content">
                    @if (isset($section->section_heading))
                        <h1 class="cus_h1 sec_title">{{ $section->section_heading ?? '' }}</h1>
                    @endif
                    <div>{!! $section->section_content ?? '' !!}</div>
                    @if (isset($section->section_btn_text))
                        <a href="{{ $section->section_btn_link ?? '' }}"
                            class="btn btn-danger cus_btn join_btn">{{ $section->section_btn_text ?? '' }}</a>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
