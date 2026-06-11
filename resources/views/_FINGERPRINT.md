# 设计指纹 - Onya Magazine (Fox Theme)

## 截图观察要点
- **category.png 直接观察**：白色背景，三层顶部 header（细顶栏+logo中间+导航底部），category title 居中+大号无衬线体，4列文章网格，每个卡片图片在上（宽幅）+粗体标题+摘要文字+日期/分类标注，底部4列 footer widget 区（Recent Posts/Tags/Facebook/Instagram），数字分页
- 配色精准：accent 橙红 #db4a37，黑色文字，白色背景，浅灰边框

## 配色
- 主色：#db4a37（按钮、高亮、链接等）
- 辅色/强调色：#db4a36
- 背景色：#ffffff（页面主背景）
- 内容区背景：#ffffff（卡片）
- 文字色：#000000（正文）
- 标题色：#000000
- 链接色：#db4a36 / 链接 hover 色：#db4a37
- 分隔线/边框色：#e0e0e0
- topbar 背景：#000000 / topbar 文字：#ffffff

## 字体
- 标题字体族：Oswald, "Helvetica Neue", Helvetica, Arial, sans-serif
- 正文字体族：Merriweather, Georgia, "Times New Roman", serif
- 导航字体族："Helvetica Neue", Helvetica, Arial, sans-serif
- 字体来源：Google Fonts（Oswald:700,regular | Merriweather:regular,300,700）
- 正文字号参考：16px
- 行高参考：1.6

## HTML DOM 骨架
- layout（index.html body 顶层）：`#wi-all.fox-outer-wrapper` 包裹全部；内有 `.masthead.header_desktop56`（三层：topbar56/main_header56/header_bottom56）、`#header_mobile56`（移动端单条 header）、`.header_mobile56__height`（高度占位）、`#wi-main.wi-main.fox-main`（主内容）、`#wi-footer.site-footer`（footer）、`.offcanvas56__element`（侧滑抽屉）；**无默认 `<header><main><footer>` 标签**
- 首页 content 区：`#wi-main` > `.builder56.sectionlist` > 多个 `.builder56__section.section56`，每个含 `.container.container--main` > `.widget56__row` > 列 > `.blog56-wrapper.widget56` > `.blog56` 各种列变体
- 分类页：`#wi-main` > `.archive56__titlebar`（titlebar56）+ `.archive56__main` > `.container.container--main` > `.primary56` > `.blog56-wrapper` > `.blog56.blog56--grid.blog56--grid--4cols`
- 文章页：`#wi-main` > `.single-placement` > `article.single56.no-sidebar.single56--narrow`，内分 `.container.container--single-header`（meta+H1）和 `.container.container--main > .primary56 > .single56__body > .entry-content`

## 模块取舍（对照 source 三页）
- 顶栏/导航：有；三层双条（topbar + main_header + header_bottom）；在 `.masthead.header_desktop56` 内
- Hero / 焦点头条区：首页有 row56 group 区（大卡片+列表+侧边），非纯色块/轮播
- 首页文章列表形态：4 列网格 + 特色 group（大图左+列表中+小卡右）
- 首页分类聚合区块：有；按分类 section 分开，每个用 heading56 标题+4列网格
- 侧边栏（列表/详情）：无（category 和 single 均 no-sidebar）
- Footer：有；4列 widget（Recent Posts/Tags/Footer/Instagram）+ 底部版权导航

## 交互取舍
- 移动菜单：有；汉堡 icon 触发，offcanvas 侧滑展开
- 返回顶部：无（source 未出现）
- 搜索交互：有（桌面端 header 左侧 search toggle）
- 其他 source 特有交互：Dark mode toggle（topbar），但不实现（复杂），导航 hover 下拉（有子菜单）

## 类名与资源路径模式
- source 典型 class/id 模式：`post56`, `blog56`, `single56`, `meta56`, `thumbnail56`, `excerpt56`, `pagination56`，后缀数字56；semantic 段落词+56数字后缀
- 禁止使用的自造模式：`{slug}-*`/`theme-*`/`site-*` 全套前缀
- source CSS 路径样例：`wp-content/themes/fox/css56/common.css`, `header-above.css`, `footer.css` 等 → 镜像为 `css56/`
- source JS 路径样例：`main.js` → `js56/main.js`
- 产出路径：`public/css56/` 和 `public/js56/`

## 静态资源命名方案
- 标识符：fox56（来自 source 的 Fox theme 56 系列）
- 样式文件路径清单：
  - `css56/common.css` → 全局变量、reset、基础排版、容器、通用组件
  - `css56/header.css` → topbar、main header、nav、mobile header、offcanvas
  - `css56/footer.css` → footer sidebar、footer bottom、footer menu
  - `css56/archive.css` → 分类 titlebar、文章 grid 卡片、分页
  - `css56/single.css` → 文章详情页、面包屑、单文章 header
  - `css56/page.css` → 静态页（about/contact/privacy/terms）、404 页
- 脚本文件路径清单：
  - `js56/main.js` → 移动端 offcanvas 菜单、导航交互
- CSS 类名风格：Fox 主题 56 系列，形如 `post56`、`blog56`、`meta56`，加上 BEM modifier `blog56--grid`
- Partial 文件命名风格示例：`post-card`, `sidebar-hot`, `breadcrumb`, `pagination`

## 版式决策 (Step 3)
- Hero 区呈现：group 区（大卡片 2/3 + 小列表 1/3），无背景图叠字，无 Hero banner
- 文章卡片：竖排（图上文下），4 列响应式
- 分类页侧边栏：无侧边栏
- 分页方式：数字分页（`.pagination56` 模式）
- 首页分区数量：4 个区（featured group + 2 个 category 块 + hot topics）

## 版式骨架
### 首页
- 整体布局：杂志感多分区（featured group + 分类聚合区块 + 热门区块）
- Header：白色背景，非粘性（桌面），移动端 sticky
- Hero 区：group layout（大卡左 + 小列表右），无图背景
- 文章卡片排列：竖排图上文下，4列
- 各板块顺序：Featured Group → 分类区块1 → 分类区块2 → Hot Topics
- Footer：4列 widget + 版权条

### 分类列表页
- 布局：无侧边栏，全宽 4 列网格
- 文章卡片：图片+粗体标题+摘要+日期/分类
- 无侧边栏

### 文章详情页
- 主内容区宽度：窄栏（narrow）居中
- 侧边栏：无
- 正文排版：Merriweather serif，宽松行高
- 文章头部：meta居中（日期+分类+作者）→ H1 → 大封面图（stretch full width）
- FAQ 区域：平铺问答（h2标题+各问h3）
- 相关文章区：有，底部 4 列网格

## 卡片风格
- 圆角：无（0）
- 阴影：无
- 边框：无（卡片间有 separator line）
- 图片比例：4:3（480×384 源图）
- Hover 效果：标题颜色变为 accent #db4a37

## 导航风格
- 位置：桌面顶部非粘性（三层）、移动端粘性
- 背景：白色
- Logo 位置：居中
- 下拉菜单：有（hover）
- 移动端折叠方式：汉堡菜单 → offcanvas 侧滑

## 调性关键词
杂志感、清新澳洲、双栏标题感

## 特殊视觉细节
- heading56 section 标题：中间文字两侧横线装饰（`heading56__line--left/right`）
- 文章卡片底部有 `.post56__sep__line` 细分隔线
- topbar 黑色背景，显示当前日期
- Logo 下方有 slogan/tagline
- nav 链接有底部 active bar（`.mk` 伪元素）

## 自检结果

- [x] _FINGERPRINT.md 已生成，含完整指纹与资源命名方案
- [x] 每个页面有且只有一个 H1
- [x] H 标签层级无跳跃（H1→H2→H3，无 H4+）
- [x] FAQ 区域仅在有数据时渲染，FAQ 区块标题使用 H2，每条问题使用 H3
- [x] 面包屑最后一项无 <a> 标签（不可点击）
- [x] 面包屑字段用的是 $crumb['absolute_url']，不是 $crumb['url']
- [x] 所有 <img> 均有非空 alt 属性（alt 降级用 $blog->title）
- [x] 文章详情页未渲染 $blog->head_img
- [x] 无任何 penci-* / wp-block-* / magcat-* 类名
- [x] 面包屑 HTML 中无 itemprop / itemscope / itemtype 属性
- [x] 无 javascript:void(0) 链接
- [x] 无 <a> 标签嵌套（卡片 figure+text 分开，thumbnail 内 a 仅含 img）
- [x] 移动端导航通过 click 而非 hover 触发
- [x] CSS 类名命名体系全文一致（56 系列后缀）
- [x] 资源引用使用 asset() 函数，无硬编码路径
- [x] Blade 注释使用 {{-- --}}，无 HTML 注释
- [x] partials/article-list.blade.php 存在（供 AJAX 调用）
- [x] 分页链接为真实 URL（非 JS 伪链接）
- [x] JSON-LD 覆盖：首页 WebSite、分类 CollectionPage、文章 Article+BreadcrumbList；FAQPage 仅在 $blog->faq 非空时输出
- [x] <html lang> 使用 app()->getLocale()
- [x] $alternate_tag 在 <head> 中输出（{!! $alternate_tag ?? '' !!}）
- [x] 产出风格与 source 指纹匹配；category.png 截图已记录观察要点
- [x] DOM：指纹含「HTML DOM 骨架」；layout/各页 content 嵌套对齐 source，未默认 header+main+footer
- [x] 类名：延续 source fox56 命名模式，无自造 `{slug}-*`/`theme-*` 全套前缀
- [x] 资源路径：CSS/JS 路径为 css56/ 和 js56/，对照 source css56/ 目录，未默认 themes/{slug}/ 目录
- [x] 反模板库：模块顺序（group→category块→hot topics）与交互清单（offcanvas/search/FAQ手风琴）由 source 指纹驱动
