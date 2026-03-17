# 📔 Aurora & Zenith Todo List

성공적인 업무 관리를 위한 프리미엄 웹 기반 데일리 체크리스트 애플리케이션입니다. 두 가지 차별화된 테마와 실시간 AWS 클라우드 동기화 기능을 제공합니다.

## ✨ 주요 특징

### 🌌 Aurora Theme (`index.html`)
- **Premium UI**: 3D 복셀 배경과 오로라 그라데이션이 적용된 화려한 디자인
- **Visual Feedback**: 할 일 완료 및 삭제 시 부드러운 Bounce 애니메이션 적용
- **Real-time Clock**: 상단 패널을 통해 실시간 날짜와 시간을 초 단위로 확인 가능
- **Progress Tracking**: 실시간 업무 달성도 프로그레스 바 제공

### 🧬 Zenith Theme (`todo/zenith.html`)
- **Modern Grid**: 카드 기반의 깔끔한 그리드 레이아웃 시스템
- **Theme Toggle**: uiverse.io 스타일의 감각적인 Dark/Light 모드 전환 버튼
- **Minimalist**: 화려한 이모지 대신 정갈한 벡터 아이콘 사용으로 가독성 극대화
- **Soft Shadows**: 부드러운 그림자 효과로 깊이감 있는 인터페이스 구현

## 🛠 기술 스택

- **Frontend**: Vanilla JS, CSS3 (Glassmorphism, Flex/Grid Layout)
- **Backend**: PHP 8.x
- **Database**: MariaDB / MySQL
- **Infrastructure**: AWS LAMP Stack
- **Version Control**: Git

## 🚀 설치 및 배포

### 1. 데이터베이스 설정
`todo/init.sql` 파일을 사용하여 테이블을 생성합니다.
```sql
CREATE DATABASE todo_db;
USE todo_db;
-- init.sql 내용 실행
```

### 2. 서버 설정
`todo/db.php`에서 데이터베이스 연결 정보를 설정합니다.
```php
$host = 'localhost';
$db   = 'todo_db';
$user = 'your_user';
$pass = 'your_password';
```

### 3. 배포 (Windows)
`todo/deploy.bat` 스크립트를 사용하여 AWS 서버로 실시간 업로드가 가능합니다. (SSH 키 설정 필요)

## 🛡 보안 사항
- **SQL Injection Prevention**: PDO Prepared Statements 사용
- **XSS Protection**: HTML 엔티티 필터링 적용
- **Credential Safety**: `.gitignore`를 통한 민감 정보 노출 방지

## 📝 라이선스
이 프로젝트는 개인 업무 효율 향상을 위해 제작되었습니다.
