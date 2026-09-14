# Hướng dẫn sửa nội dung website AEF 2026

Tài liệu này trả lời 1 câu duy nhất cho từng trang/khối: **BTC tự sửa được ở đâu, và chỗ nào bắt buộc phải nhờ lập trình viên.**

Nguyên tắc chung của site: mỗi khối nội dung có 1 trong 3 dạng —
1. **Field quản trị** — 1 màn hình riêng trong menu **AEF Content**, có ô nhập sẵn cho từng phần (thường tách Anh/Việt), ảnh nền chọn từ Thư viện. Sửa xong bấm Lưu, không cần biết code.
2. **Bài đăng (CPT)** — sửa như 1 bài viết WordPress bình thường (Phiên, Diễn giả, Đối tác, Tin/thông cáo), có ô soạn thảo Anh/Việt ngay trên màn hình sửa bài, gõ vào là hiện ra trên trang.
3. **Code cứng** — nội dung nằm trực tiếp trong file PHP của theme. Đổi gì cũng phải sửa code, không có ô nào trong wp-admin có tác dụng.

Khi mở 1 trang (post_type "page") trong wp-admin mà không chắc nó thuộc nhóm nào, khối "AEF — English / Vietnamese" trên màn sửa bài giờ tự hiện ghi chú tương ứng — tài liệu này là bản đầy đủ hơn của đúng ghi chú đó.

## Trang chủ

Quản trị tại **AEF Content → Trang chủ**. 15/16 khối có đủ ảnh nền + chữ song ngữ + kéo-thả thứ tự/ẩn-hiện. Khối "Tin tức" không có ảnh nền riêng (lấy ảnh từ từng bài Tin).

**Ngoại lệ — code cứng:**
- Nội dung chi tiết của **4 trụ cột** (trong khối "Chủ đề") hiện đang lặp lại (khác nguồn) với dữ liệu đã có ở trang Chuyên đề — cần nối lại, việc nhỏ.
- **3 dòng nội dung** (mô tả 3 nhóm phiên chuyên đề, cũng trong khối "Chủ đề") — chưa có field nào, code cứng hoàn toàn.

## Chương trình / lịch trình phiên

- **Nội dung từng phiên** (tên, giờ, phòng, diễn giả, tóm tắt...): sửa như 1 bài viết bình thường ở **Phiên** (CPT `aef_session`), có metabox riêng.
- **Phòng**: dropdown 3 phòng cố định (mới thêm) — chọn từ danh sách, không gõ tay tự do nữa.
- **Thứ tự hiển thị + hiện/ẩn ở trang chủ**: màn **AEF Content → Sắp xếp chương trình** — kéo-thả theo từng ngày.
- Trang `/programme/` (danh sách đầy đủ) tự động lấy đúng dữ liệu này, không cần sửa gì thêm.

## Giới thiệu (About)

Quản trị tại **AEF Content → Giới thiệu**. Độ chi tiết field tốt nhất site — từng mục nhỏ (01–05 mục tiêu, 3 trụ cột thường niên, mô hình tổ chức...) đều có ô riêng. Không có khoảng trống đáng kể.

## Chuyên đề (4 trụ cột)

Quản trị tại **AEF Content → Chuyên đề**. Mỗi trụ cột có đủ: tiêu đề, tên ngắn, câu dẫn, mô tả ngắn (card), thân bài dài, câu hỏi dẫn dắt — cả Anh và Việt.

## Đối tác / Tin & thông cáo / Diễn giả

Sửa như bài viết WordPress bình thường (CPT `aef_partner` / `aef_story` / `aef_speaker`), có ô soạn thảo Anh/Việt ngay trên màn sửa bài — gõ vào hiện ra trên trang thật. Thứ tự & bật/tắt logo đối tác trên trang chủ: **AEF Content → Logo trang chủ**.

## Khung trang (menu, footer)

Quản trị tại **AEF Content → Khung trang**: các mục menu, dòng giới thiệu ngắn ở footer, các link chân trang. Menu song ngữ đầy đủ ở **Menu EN/VI**.

## Trang trong — Đối tác (`/2026/partners/`)

Phần mở đầu (tiêu đề, đoạn dẫn, ảnh) sửa tại **AEF Content → Trang trong**. Danh sách/logo đối tác lấy từ CPT Đối tác.

---

## Nhóm trang CẦN NHỜ LẬP TRÌNH VIÊN (không có field nào)

5 trang sau có bố cục thiết kế riêng (lưới ảnh, thẻ, bảng số liệu...) — theo quyết định giữ nguyên phần nhìn thay vì chuyển sang gõ tự do, nên **toàn bộ nội dung nằm trong code**, kể cả khi bạn thấy 1 ô soạn thảo Anh/Việt hiện ra trên màn sửa trang — ô đó **không có tác dụng gì** cho 5 trang này:

| Trang | URL | File code |
|---|---|---|
| Cẩm nang đi lại | `/travel/`, `/venue/`, `/hotels/`, `/transport/` | `inc/travel.php` |
| Cách đăng ký / Đại biểu | `/2026/delegates/how-to-register/`, `/2026/delegates/` | `templates/delegates.php` |
| Trung tâm Hỗ trợ | `/2026/support/` | `templates/support.php` |
| Báo chí / Tác nghiệp | `/2026/support/media/` | `templates/media-support.php` |
| Kỳ 2025 (tổng kết) | `/editions/2025/` | `inc/editions.php` |

Muốn đổi nội dung 5 trang này, báo lập trình viên (Claude hoặc người kế nhiệm) kèm nội dung mới — sửa trực tiếp trong file tương ứng, không có cách nào khác trong phạm vi kiến trúc hiện tại.

**Lưu ý cho trang mới:** nếu tạo 1 trang WordPress mới (post_type "page") với slug KHÔNG trùng bất kỳ tên nào ở trên và không trùng `about`/`topics`/`partners`, hệ thống mặc định sẽ hiển thị đúng nội dung gõ trong ô soạn thảo Anh/Việt trên màn sửa trang — nghĩa là trang mới tự do gõ được ngay, không cần code.
