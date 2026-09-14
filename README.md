# AEF 2026 — code website (aef.yea.vn / aef2026.yea.vn)

Repo này chỉ chứa **code riêng của dự án**, không chứa WordPress core, theme mặc định, hay plugin bên thứ ba (những phần đó cài lại được từ WordPress.org, không cần đưa vào git).

## Cấu trúc

```
themes/aef-2026/      Theme chính của site (giao diện, template, logic hiển thị)
mu-plugins/           Must-use plugin: CPT (Phiên/Diễn giả/Đối tác...), khung quản trị "AEF Content"
plugins/aef-demo-apply/  Plugin tự viết để áp payload demo lên site khi kích hoạt
```

## Không đưa vào repo (cố ý)

- `themes/twentytwentyfive|four|three` — theme mặc định WordPress
- `plugins/` khác `aef-demo-apply` (akismet, all-in-one-wp-migration, foxtool, sqlite-database-integration, wordpress-importer...) — plugin bên thứ ba
- `uploads/` — thư viện media, quá nặng và không phải code
- `ai1wm-backups/`, `upgrade/`, `database/` — file tạm/backup của công cụ, không phải nguồn code

## Deploy

Trên server (DirectAdmin), thư mục deploy của Git Manager nên trỏ **đúng vào thư mục `wp-content`** của site (không phải root site), vì cấu trúc repo này mô phỏng trực tiếp nội dung bên trong `wp-content`.
