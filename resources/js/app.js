import './bootstrap';


// 引入 wangEditor 的 CSS
import '@wangeditor/editor/dist/css/style.css'

// 只导入需要的模块（注意：不再导入 MENU_CONF）
import { createEditor, createToolbar } from '@wangeditor/editor'

// 挂载到 window，方便在 Blade 中使用
window.wangEditor = {
  createEditor,
  createToolbar
}
