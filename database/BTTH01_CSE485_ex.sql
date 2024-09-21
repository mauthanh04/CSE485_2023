-- 4a. Để liệt kê các bài viết về các bài hát thuộc thể loại Nhạc trữ tình, bạn có thể sử dụng câu lệnh SQL
SELECT baiviet.ma_bviet, baiviet.tieude, baiviet.ten_bhat, tacgia.ten_tgia, theloai.ten_tloai, baiviet.ngayviet
FROM baiviet
JOIN theloai ON baiviet.ma_tloai = theloai.ma_tloai
JOIN tacgia ON baiviet.ma_tgia = tacgia.ma_tgia
WHERE theloai.ten_tloai = 'Nhạc trữ tình';

-- 4b. Để liệt kê các bài viết của tác giả Nhacvietplus, bạn có thể sử dụng câu lệnh SQL sau:
SELECT baiviet.ma_bviet, baiviet.tieude, baiviet.ten_bhat, theloai.ten_tloai, baiviet.ngayviet
FROM baiviet
JOIN tacgia ON baiviet.ma_tgia = tacgia.ma_tgia
JOIN theloai ON baiviet.ma_tloai = theloai.ma_tloai
WHERE tacgia.ten_tgia = 'Nhacvietplus';

-- 4c. Liệt kê các thể loại nhạc chưa có bài viết cảm nhận nào.
SELECT theloai.ma_tloai, theloai.ten_tloai
FROM theloai
LEFT JOIN baiviet ON theloai.ma_tloai = baiviet.ma_tloai
WHERE baiviet.ma_bviet IS NULL;

/* 4d. Liệt kê các bài viết với các thông tin sau: mã bài viết, tên bài viết, tên bài hát, tên tác giả, tên
thể loại, ngày viết. */
SELECT baiviet.ma_bviet, baiviet.tieude, baiviet.ten_bhat, tacgia.ten_tgia, theloai.ten_tloai, baiviet.ngayviet
FROM baiviet
JOIN tacgia ON baiviet.ma_tgia = tacgia.ma_tgia
JOIN theloai ON baiviet.ma_tloai = theloai.ma_tloai;

-- 4e. Tìm thể loại có số bài viết nhiều nhất
SELECT theloai.ma_tloai, theloai.ten_tloai, COUNT(baiviet.ma_bviet) AS so_bai_viet
FROM theloai
JOIN baiviet ON theloai.ma_tloai = baiviet.ma_tloai
GROUP BY theloai.ma_tloai, theloai.ten_tloai
ORDER BY so_bai_viet DESC
LIMIT 1;

-- 4f. Liệt kê 2 tác giả có số bài viết nhiều nhất
SELECT tacgia.ma_tgia, tacgia.ten_tgia, COUNT(baiviet.ma_bviet) AS so_bai_viet
FROM tacgia
JOIN baiviet ON tacgia.ma_tgia = baiviet.ma_tgia
GROUP BY tacgia.ma_tgia, tacgia.ten_tgia
ORDER BY so_bai_viet DESC
LIMIT 2;

/* 4g. g. Liệt kê các bài viết về các bài hát có tựa bài hát chứa 1 trong các từ “yêu”, “thương”, “anh”,
“em” */
SELECT baiviet.ma_bviet, baiviet.tieude, baiviet.ten_bhat, tacgia.ten_tgia, theloai.ten_tloai, baiviet.ngayviet
FROM baiviet
JOIN tacgia ON baiviet.ma_tgia = tacgia.ma_tgia
JOIN theloai ON baiviet.ma_tloai = theloai.ma_tloai
WHERE baiviet.ten_bhat LIKE '%yêu%'
   OR baiviet.ten_bhat LIKE '%thương%'
   OR baiviet.ten_bhat LIKE '%anh%'
   OR baiviet.ten_bhat LIKE '%em%';

/* 4h. Liệt kê các bài viết về các bài hát có tiêu đề bài viết hoặc tựa bài hát chứa 1 trong các từ
“yêu”, “thương”, “anh”, “em” */
SELECT baiviet.ma_bviet, baiviet.tieude, baiviet.ten_bhat, tacgia.ten_tgia, theloai.ten_tloai, baiviet.ngayviet
FROM baiviet
JOIN tacgia ON baiviet.ma_tgia = tacgia.ma_tgia
JOIN theloai ON baiviet.ma_tloai = theloai.ma_tloai
WHERE baiviet.tieude LIKE '%yêu%'
   OR baiviet.tieude LIKE '%thương%'
   OR baiviet.tieude LIKE '%anh%'
   OR baiviet.tieude LIKE '%em%'
   OR baiviet.ten_bhat LIKE '%yêu%'
   OR baiviet.ten_bhat LIKE '%thương%'
   OR baiviet.ten_bhat LIKE '%anh%'
   OR baiviet.ten_bhat LIKE '%em%';

/* 4i. Tạo 1 view có tên vw_Music để hiển thị thông tin về Danh sách các bài viết kèm theo Tên
thể loại và tên tác giả */
CREATE VIEW vw_Music AS
SELECT baiviet.ma_bviet, baiviet.tieude, baiviet.ten_bhat, tacgia.ten_tgia, theloai.ten_tloai, baiviet.ngayviet
FROM baiviet
JOIN tacgia ON baiviet.ma_tgia = tacgia.ma_tgia
JOIN theloai ON baiviet.ma_tloai = theloai.ma_tloai;

/* 4j. Tạo 1 thủ tục có tên sp_DSBaiViet với tham số truyền vào là Tên thể loại và trả về danh sách
Bài viết của thể loại đó. Nếu thể loại không tồn tại thì hiển thị thông báo lỗi. */

DELIMITER $$

CREATE PROCEDURE sp_DSBaiViet(IN tenTheLoai VARCHAR(50))
BEGIN
    -- Khai báo biến để lưu số lượng thể loại có tồn tại hay không
    DECLARE so_luong INT;
    
    -- Kiểm tra xem thể loại có tồn tại không
    SELECT COUNT(*) INTO so_luong FROM theloai WHERE ten_tloai = tenTheLoai;

    -- Nếu thể loại không tồn tại, trả về thông báo lỗi
    IF so_luong = 0 THEN
        SELECT 'Thể loại không tồn tại' AS ThongBao;
    ELSE
        -- Nếu thể loại tồn tại, trả về danh sách bài viết
        SELECT baiviet.ma_bviet, baiviet.tieude, baiviet.ten_bhat, tacgia.ten_tgia, theloai.ten_tloai, baiviet.ngayviet
        FROM baiviet
        JOIN theloai ON baiviet.ma_tloai = theloai.ma_tloai
        JOIN tacgia ON baiviet.ma_tgia = tacgia.ma_tgia
        WHERE theloai.ten_tloai = tenTheLoai;
    END IF;
END$$

DELIMITER ;


/* 4k. Thêm mới cột SLBaiViet vào trong bảng theloai. Tạo 1 trigger có tên tg_CapNhatTheLoai để
khi thêm/sửa/xóa bài viết thì số lượng bài viết trong bảng theloai được cập nhật theo. */

ALTER TABLE theloai ADD COLUMN SLBaiViet INT DEFAULT 0;

--Trigger cho thêm bài viết
DELIMITER $$

CREATE TRIGGER tg_CapNhatTheLoai_Insert
AFTER INSERT ON baiviet
FOR EACH ROW
BEGIN
    UPDATE theloai
    SET SLBaiViet = (SELECT COUNT(*) FROM baiviet WHERE ma_tloai = NEW.ma_tloai)
    WHERE ma_tloai = NEW.ma_tloai;
END$$

DELIMITER ;

--Trigger cho sửa bài viết:
DELIMITER $$

CREATE TRIGGER tg_CapNhatTheLoai_Update
AFTER UPDATE ON baiviet
FOR EACH ROW
BEGIN
    IF NEW.ma_tloai <> OLD.ma_tloai THEN
        -- Cập nhật số lượng bài viết của thể loại cũ
        UPDATE theloai
        SET SLBaiViet = (SELECT COUNT(*) FROM baiviet WHERE ma_tloai = OLD.ma_tloai)
        WHERE ma_tloai = OLD.ma_tloai;

        -- Cập nhật số lượng bài viết của thể loại mới
        UPDATE theloai
        SET SLBaiViet = (SELECT COUNT(*) FROM baiviet WHERE ma_tloai = NEW.ma_tloai)
        WHERE ma_tloai = NEW.ma_tloai;
    END IF;
END$$

DELIMITER ;

--Trigger cho xóa bài viết

DELIMITER $$

CREATE TRIGGER tg_CapNhatTheLoai_Delete
AFTER DELETE ON baiviet
FOR EACH ROW
BEGIN
    UPDATE theloai
    SET SLBaiViet = (SELECT COUNT(*) FROM baiviet WHERE ma_tloai = OLD.ma_tloai)
    WHERE ma_tloai = OLD.ma_tloai;
END$$

DELIMITER ;

/* 4l. Bổ sung thêm bảng Users để lưu thông tin Tài khoản đăng nhập và sử dụng cho chức năng
Đăng nhập/Quản trị trang web. */

-- tạo bảng users
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usersname VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);


-- dữ liệu users
INSERT INTO users (usersname, password) VALUES ('admin', '123'), ('user1', '123'), ('user2', '123');