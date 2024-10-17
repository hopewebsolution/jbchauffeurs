<div class="row remove_this_section" style="padding: 10px; border: 1px solid; margin-bottom: 10px;">

    <input type="hidden" name="section_id[]" value="{{ isset($section) ? $section->id : '' }}">
    <input type="hidden" class="section_type" name="section_type[]"
        value="{{ isset($section) ? $section->section_type : '' }}">
    <input type="hidden" class="use_section" name="use_section[]"
        value="{{ isset($section) && $section->id ? '1' : '0' }}">

    <div class="col-md-12 col-sm-12 col-xs-12">
        <label for="section_heading" class="section_heading"><span
                class="section_type_show">{{ isset($section) ? ($section->section_type == 'left_section' ? 'Left' : 'Right') : '' }}</span>
            Section </label>
        <button type="button" class="btn btn-xs btn-danger remove_section" style="float: right; margin-top: 0px;"><i
                class="fa fa-minus"></i>
            Remove</button>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <label for="section_heading" class="section_heading">Section Heading:<span
                class="text-danger small">*</span></label>
        <input type="text" id="section_heading" name="section_heading[]" class="form-control"
            value="{{ isset($section) ? $section->section_heading : '' }}">
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <label for="section_image" class="section_image">Section Image:<span class="text-danger small">*</span></label>
        <input type="file" id="section_image" name="section_image[]" class="form-control">
        @if (isset($section))
            <div class="">
                <img src="{{ isset($section) ? $section->image : '' }}" style="width: 100px;">
            </div>
            <input type="hidden" name="old_section_image[]"
                value="{{ isset($section) ? $section->section_image : '' }}">
        @endif
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <div class="row">
            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                <label for="section_btn_text" class="section_btn_text">Section Button:<span
                        class="text-danger small">*</span></label>
                <input type="text" id="section_btn_text" name="section_btn_text[]" class="form-control"
                    value="{{ isset($section) ? $section->section_btn_text : '' }}">
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12 form-group">
                <label for="section_btn_link" class="section_btn_link">Section Button Link:<span
                        class="text-danger small">*</span></label>
                <input type="text" id="section_btn_link" name="section_btn_link[]" class="form-control"
                    value="{{ isset($section) ? $section->section_btn_link : '' }}">
            </div>
        </div>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
        <label for="section_content" class="section_content">Section Content:<span
                class="text-danger small">*</span></label>
        <textarea id="section_content" name="section_content[]" class="form-control editor">{!! isset($section) ? $section->section_content : '' !!}</textarea>
    </div>
</div>
