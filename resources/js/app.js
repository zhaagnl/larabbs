import './bootstrap';


// 引入 wangEditor 的 CSS
import '@wangeditor/editor/dist/css/style.css'

// 引入 wangEditor 的 JS
import { createEditor, createToolbar } from '@wangeditor/editor'

// DOM 加载完成后自动初始化编辑器
document.addEventListener('DOMContentLoaded', function () {
  const editorContainer = document.getElementById('editor-container')
  const toolbarContainer = document.getElementById('toolbar-container')
  const form = editorContainer ? editorContainer.closest('form') : null

  if (editorContainer && toolbarContainer) {
    // 读取初始内容（来自 data-initial-content 属性）
    const initialHtml = editorContainer.dataset.initialContent || '<p><br></p>'

    // 创建编辑器
    const editor = createEditor({
      selector: editorContainer,
      html: initialHtml,
      config: {
        placeholder: '请输入内容...',
      },
    })

    // 创建工具栏
    createToolbar({
      editor,
      selector: toolbarContainer,
      config: {},
      mode: 'default', // 可选 'simple'
    })

    // 将编辑器实例保存到全局（便于调试）
    window.editor = editor

    // 如果找到了所属表单，自动绑定提交同步
    if (form) {
      const hiddenTextarea = form.querySelector('textarea[name="body"]')
      form.addEventListener('submit', function () {
        if (hiddenTextarea) {
          hiddenTextarea.value = editor.getHtml()
        }
      })
    }
  }
})
