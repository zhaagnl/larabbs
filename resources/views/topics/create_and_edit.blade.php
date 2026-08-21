@extends('layouts.app')

@section('content')

<div class="container">
  <div class="col-md-10 offset-md-1">
    <div class="card ">

      <div class="card-body">
        <h2 class="">
          <i class="far fa-edit"></i>
          @if($topic->id)
            编辑话题
          @else
            新建话题
          @endif
        </h2>

        <hr>


        @if($topic->id)
          <form action="{{ route('topics.update', $topic->id) }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
          <input type="hidden" name="_method" value="PUT">
        @else
          <form action="{{ route('topics.store') }}" method="POST" accept-charset="UTF-8" enctype="multipart/form-data">
        @endif


          <input type="hidden" name="_token" value="{{ csrf_token() }}">

          @include('shared._error')

          <div class="mb-3">
            <label for="title-field">标题</label>
            <input class="form-control" type="text" name="title" id="title-field" value="{{ old('title', $topic->title ) }}" placeholder="请填写标题" required/>
          </div>

          <div class="mb-3">
            <label for="category_id-field">请选择分类</label>
            <select class="form-control" name="category_id" id="category_id-field" required>
              <option value="" hidden disabled {{ $topic->id ? '' : 'selected' }}>请选择分类</option>
              @foreach($categories as $value)
              <option value="{{ $value->id }}" {{ $topic->category_id == $value->id ? 'selected' : '' }}>
                {{ $value->name }}
              </option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label >内容</label>
            {{-- wangEditor 工具栏容器 --}}
            <div id="toolbar-container"></div>
            {{-- wangEditor 编辑区容器（通过 data-initial-content 传递初始内容） --}}
            <div id="editor-container" style="height: 400px; border: 1px solid #ccc; border-radius: 4px;"
              data-initial-content="{{ old('body', $topic->body) }}">
            </div>
            {{-- 隐藏的 textarea，用于表单提交 --}}
            <textarea name="body" id="editor" style="display:none;">{{ old('body', $topic->body) }}</textarea>
          </div>

          <div class="well well-sm">
            <button type="submit" class="btn btn-primary"><i class="far fa-save mr-2" aria-hidden="true"></i>保存</button>

          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const { createEditor, createToolbar } = window.wangEditor;

    // 配置上传图片（注意：MENU_CONF 直接写在 config 里）
    const editorConfig = {
        placeholder: '请输入内容...',
        MENU_CONF: {
            uploadImage: {
                server: '{{ route('topics.upload_image') }}',
                fieldName: 'upload_file',
                maxFileSize: 1 * 1024 * 1024,
                allowedFileTypes: ['image/*'],
                meta: {
                    _token: '{{ csrf_token() }}'
                },
                customInsert(res, insertFn) {
                    if (res.success && res.file_path) {
                        insertFn(res.file_path, '', '');
                    } else {
                        alert(res.msg || '上传失败');
                    }
                }
            }
        }
    };

    // 获取容器
    const editorContainer = document.getElementById('editor-container');
    const toolbarContainer = document.getElementById('toolbar-container');
    const initialHtml = editorContainer.dataset.initialContent || '<p><br></p>';

    // 创建编辑器
    const editor = createEditor({
        selector: editorContainer,
        html: initialHtml,
        config: editorConfig
    });

    // 创建工具栏
    createToolbar({
        editor,
        selector: toolbarContainer,
        config: {},
        mode: 'default'
    });

    // 表单提交时同步内容
    const form = editorContainer.closest('form');
    const hiddenTextarea = form.querySelector('textarea[name="body"]');
    form.addEventListener('submit', function () {
        hiddenTextarea.value = editor.getHtml();
    });

    // 暴露编辑器实例（可选）
    window.editor = editor;
});
</script>
@endsection
