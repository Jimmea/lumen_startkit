# Tag trong Git
Tìm hiểu về tag, tạo ra một tag mới đánh dấu tag vào một commit cụ thể, checkout bằng cách sử dụng tag, push một tag mới lên remote Repo

Tag là một cái tên dùng để đánh dấu một điểm nào đó trong lịch sử quá trình commit khi cho rằng điểm đó là quan trọng, cần chú ý.

## Lệnh làm việc với Tag trong Git
**Liệt kê các Tag**
```
git tag
```

**Tạo ra một Tag mới đánh dấu vào commit cuối**

Tạo ra một tag có tên `beta` với dòng chú thích `Phien ban thu nghiem`
```
Tạo ra một tag có tên beta với dòng chú thích Phien ban thu nghiem
```
Lúc này hệ thống Git đã tạo ra một Tag và đánh dấu Tag này vào điểm commit cuối, có thể dùng lệnh git tag để xem lại danh sách Tag và lệnh git log để xem các Tag đánh dấu vào commit có hash nào


**Tạo ra một Tag mới đánh dấu vào commit cũ**
Nếu muốn đánh dấu vào một điểm bất kỳ trong lịch sử commit, cần lấy mã hash của commit đó (lệnh git log), giả sử commit cũ nào đó có mã hash với các giá trị đầu là `9095f7db3`..., tạo ra một Tag đánh dấu cho commit đó như sau:
```
git tag -a beta2 -m "Phien ban thu nghiem 2" 9fceb02
```

**Xem thông tin về commit được gắn tag**
```
git show tagname
```

**Cập nhật tag lên Remote**
Mặc định lệnh `git push` để cập nhật một dữ liệu code lên Remote nó không có push các tag. Nếu muốn cập nhật lên Remote phải chỉ ra bằng một lệnh git push cụ thể, ví dụ
```
git push origin tagname
```

Cập nhật tất cả các tag

```
git push origin --tags
```

**Quay về một phiên bản bằng Tag**
Bình thường quan về một phiên bản nào đó bằng cách chỉ ra mã hash của phiên bản cũ, nhưng nếu có tag thì dùng tag sẽ gợi nhớ và có vẻ dễ hiểu hơn

```
git checkout tagname
```

Vì lệnh git `checkout` nó làm cho con trỏ HEAD bị tách ra, nên nếu muốn các commit sau thời điểm checkout được giữ lại thì có thể tạo luôn nhánh branch mới bắt đầu từ tag này
```
git checkout -b newbranchname tagname
```

**Xóa một tag**
Để xóa một tag thì cần thực hiện xóa cả ở Local và ở Remote (nếu đã push tag)
```
git push --delete origin tagname
git tag -d tagname
```



