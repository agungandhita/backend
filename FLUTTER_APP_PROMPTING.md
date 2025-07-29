# Flutter Lab Learning App - Development Guide

## 🎯 Project Overview
Aplikasi mobile pembelajaran alat-alat laboratorium dengan sistem kuis bertingkat, video tutorial, dan tracking progress pengguna. Aplikasi ini dirancang untuk mahasiswa/siswa yang belajar tentang peralatan laboratorium.

## 🌐 API Configuration

### Development Environment
```dart
// lib/config/api_config.dart
class ApiConfig {
  // Gunakan NGROK URL untuk testing dengan device fisik
  static const String baseUrl = 'https://your-ngrok-url.ngrok.io/api';
  
  // Untuk emulator/simulator (localhost)
  static const String localUrl = 'http://127.0.0.1:8000/api';
  
  // Auto-detect environment
  static String get apiUrl {
    return kDebugMode ? localUrl : baseUrl;
  }
}
```

### NGROK Setup Instructions
1. Install NGROK: `brew install ngrok` (macOS)
2. Start Laravel server: `php artisan serve`
3. Expose dengan NGROK: `ngrok http 8000`
4. Copy HTTPS URL dari NGROK dan update `baseUrl`
5. Restart Flutter app untuk apply perubahan

## 🔐 Authentication System

### Laravel Sanctum Integration
```dart
// lib/services/auth_service.dart
class AuthService {
  static const String _tokenKey = 'auth_token';
  
  // Store token securely
  static Future<void> saveToken(String token) async {
    final prefs = await SharedPreferences.getInstance();
    await prefs.setString(_tokenKey, token);
  }
  
  // Get stored token
  static Future<String?> getToken() async {
    final prefs = await SharedPreferences.getInstance();
    return prefs.getString(_tokenKey);
  }
  
  // Add auth header to requests
  static Future<Map<String, String>> getAuthHeaders() async {
    final token = await getToken();
    return {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
      if (token != null) 'Authorization': 'Bearer $token',
    };
  }
}
```## 📱 App Architecture & Structure

### Project Structure
```
lib/
├── config/
│   ├── api_config.dart
│   └── app_config.dart
├── models/
│   ├── user.dart
│   ├── tool.dart
│   ├── quiz.dart
│   ├── score.dart
│   └── video.dart
├── services/
│   ├── auth_service.dart
│   ├── api_service.dart
│   └── storage_service.dart
├── providers/
│   ├── auth_provider.dart
│   ├── quiz_provider.dart
│   └── app_provider.dart
├── screens/
│   ├── auth/
│   ├── home/
│   ├── tools/
│   ├── videos/
│   ├── quiz/
│   └── profile/
├── widgets/
│   ├── common/
│   └── custom/
└── utils/
    ├── constants.dart
    ├── helpers.dart
    └── validators.dart
```

## 🔑 Authentication Flow

### 1. Login Screen
```dart
// lib/screens/auth/login_screen.dart
class LoginScreen extends StatefulWidget {
  @override
  _LoginScreenState createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  final _formKey = GlobalKey<FormState>();
  final _emailController = TextEditingController();
  final _passwordController = TextEditingController();
  bool _isLoading = false;

  Future<void> _login() async {
    if (!_formKey.currentState!.validate()) return;
    
    setState(() => _isLoading = true);
    
    try {
      final authProvider = Provider.of<AuthProvider>(context, listen: false);
      await authProvider.login(
        _emailController.text,
        _passwordController.text,
      );
      
      Navigator.pushReplacementNamed(context, '/home');
    } catch (e) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text('Login gagal: ${e.toString()}')),
      );
    } finally {
      setState(() => _isLoading = false);
    }
  }
}
```

**API Endpoint**: `POST /login`
**Request Body**:
```json
{
  "email": "user@example.com",
  "password": "password123"
}
```

### 2. Register Screen
**API Endpoint**: `POST /register`
**Required Fields**: name, email, password, password_confirmation, kelas
**Optional Fields**: phone, bio

### 3. Password Reset Flow
- **Forgot Password**: `POST /forgot-password`
- **Reset Password**: `POST /reset-password`

## 🏠 Main Navigation Structure

### Bottom Navigation Implementation
```dart
// lib/screens/main/main_screen.dart
class MainScreen extends StatefulWidget {
  @override
  _MainScreenState createState() => _MainScreenState();
}

class _MainScreenState extends State<MainScreen> {
  int _currentIndex = 0;
  
  final List<Widget> _screens = [
    HomeScreen(),
    ToolsScreen(),
    VideosScreen(),
    QuizScreen(),
    ProfileScreen(),
  ];
  
  final List<BottomNavigationBarItem> _navItems = [
    BottomNavigationBarItem(
      icon: Icon(Icons.home),
      label: 'Home',
    ),
    BottomNavigationBarItem(
      icon: Icon(Icons.build),
      label: 'Tools',
    ),
    BottomNavigationBarItem(
      icon: Icon(Icons.play_circle),
      label: 'Videos',
    ),
    BottomNavigationBarItem(
      icon: Icon(Icons.quiz),
      label: 'Quiz',
    ),
    BottomNavigationBarItem(
      icon: Icon(Icons.person),
      label: 'Profile',
    ),
  ];
}
```

## 📊 Dashboard Implementation

### Home Screen dengan Real-time Stats
```dart
// lib/screens/home/home_screen.dart
class HomeScreen extends StatefulWidget {
  @override
  _HomeScreenState createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  Map<String, dynamic>? dashboardStats;
  bool isLoading = true;
  
  @override
  void initState() {
    super.initState();
    _loadDashboardStats();
  }
  
  Future<void> _loadDashboardStats() async {
    try {
      final stats = await ApiService.getDashboardStats();
      setState(() {
        dashboardStats = stats;
        isLoading = false;
      });
    } catch (e) {
      setState(() => isLoading = false);
      // Handle error
    }
  }
  
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Lab Learning'),
        actions: [
          IconButton(
            icon: Icon(Icons.notifications),
            onPressed: () => _showNotifications(),
          ),
        ],
      ),
      body: isLoading 
        ? Center(child: CircularProgressIndicator())
        : RefreshIndicator(
            onRefresh: _loadDashboardStats,
            child: _buildDashboardContent(),
          ),
    );
  }
  
  Widget _buildDashboardContent() {
    return SingleChildScrollView(
      padding: EdgeInsets.all(16),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          _buildWelcomeCard(),
          SizedBox(height: 16),
          _buildProgressCard(),
          SizedBox(height: 16),
          _buildQuickActions(),
          SizedBox(height: 16),
          _buildRecentActivity(),
        ],
      ),
    );
  }
}
```

### API Endpoints untuk Dashboard
- **Dashboard Stats**: `GET /dashboard/stats`
- **App Stats**: `GET /app/stats`
- **User Progress**: Included in user profile

**Response Format**:
```json
{
  "user_stats": {
    "total_quizzes_completed": 12,
    "average_score": 85.5,
    "current_level": "Sedang",
    "progress_percentage": 67.5
  },
  "app_stats": {
    "total_tools": 45,
    "total_videos": 23,
    "total_users": 156
  }
}
```

## 🔧 Tools Module Implementation

### Tools Screen dengan Search & Filter
```dart
// lib/screens/tools/tools_screen.dart
class ToolsScreen extends StatefulWidget {
  @override
  _ToolsScreenState createState() => _ToolsScreenState();
}

class _ToolsScreenState extends State<ToolsScreen> {
  List<Tool> tools = [];
  List<Category> categories = [];
  String searchQuery = '';
  int? selectedCategoryId;
  bool isLoading = true;
  bool isGridView = true;
  
  @override
  void initState() {
    super.initState();
    _loadInitialData();
  }
  
  Future<void> _loadInitialData() async {
    await Future.wait([
      _loadCategories(),
      _loadTools(),
    ]);
  }
  
  Future<void> _loadTools() async {
    try {
      final response = await ApiService.getTools(
        categoryId: selectedCategoryId,
        search: searchQuery.isNotEmpty ? searchQuery : null,
      );
      setState(() {
        tools = response;
        isLoading = false;
      });
    } catch (e) {
      setState(() => isLoading = false);
      _showError('Gagal memuat data tools');
    }
  }
  
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Lab Tools'),
        actions: [
          IconButton(
            icon: Icon(isGridView ? Icons.list : Icons.grid_view),
            onPressed: () => setState(() => isGridView = !isGridView),
          ),
        ],
      ),
      body: Column(
        children: [
          _buildSearchAndFilter(),
          Expanded(
            child: isLoading
              ? Center(child: CircularProgressIndicator())
              : _buildToolsList(),
          ),
        ],
      ),
    );
  }
  
  Widget _buildSearchAndFilter() {
    return Container(
      padding: EdgeInsets.all(16),
      child: Column(
        children: [
          // Search Bar
          TextField(
            decoration: InputDecoration(
              hintText: 'Cari alat laboratorium...',
              prefixIcon: Icon(Icons.search),
              border: OutlineInputBorder(
                borderRadius: BorderRadius.circular(12),
              ),
            ),
            onChanged: (value) {
              setState(() => searchQuery = value);
              _debounceSearch();
            },
          ),
          SizedBox(height: 12),
          // Category Filter
          SingleChildScrollView(
            scrollDirection: Axis.horizontal,
            child: Row(
              children: [
                _buildCategoryChip('Semua', null),
                ...categories.map((category) => 
                  _buildCategoryChip(category.nama, category.id)
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}
```

### Tool Detail Screen
```dart
// lib/screens/tools/tool_detail_screen.dart
class ToolDetailScreen extends StatefulWidget {
  final int toolId;
  
  ToolDetailScreen({required this.toolId});
  
  @override
  _ToolDetailScreenState createState() => _ToolDetailScreenState();
}

class _ToolDetailScreenState extends State<ToolDetailScreen> {
  Tool? tool;
  bool isLoading = true;
  
  @override
  void initState() {
    super.initState();
    _loadToolDetail();
  }
  
  Future<void> _loadToolDetail() async {
    try {
      final response = await ApiService.getTool(widget.toolId);
      setState(() {
        tool = response;
        isLoading = false;
      });
    } catch (e) {
      setState(() => isLoading = false);
      _showError('Gagal memuat detail tool');
    }
  }
  
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text(tool?.nama ?? 'Tool Detail'),
        actions: [
          IconButton(
            icon: Icon(Icons.share),
            onPressed: () => _shareToolInfo(),
          ),
        ],
      ),
      body: isLoading
        ? Center(child: CircularProgressIndicator())
        : _buildToolDetail(),
    );
  }
  
  Widget _buildToolDetail() {
    return SingleChildScrollView(
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          // Tool Image
          _buildToolImage(),
          
          // Tool Info
          Padding(
            padding: EdgeInsets.all(16),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  tool!.nama,
                  style: Theme.of(context).textTheme.headlineSmall,
                ),
                SizedBox(height: 8),
                _buildCategoryBadge(),
                SizedBox(height: 16),
                
                // Description
                _buildSection('Deskripsi', tool!.deskripsi),
                
                // Function
                _buildSection('Fungsi', tool!.fungsi),
                
                // Video Section
                if (tool!.urlVideo != null) _buildVideoSection(),
                
                // PDF Section
                if (tool!.filePdf != null) _buildPdfSection(),
                
                // Tags
                if (tool!.tags != null && tool!.tags!.isNotEmpty)
                  _buildTagsSection(),
              ],
            ),
          ),
        ],
      ),
    );
  }
}
```

### Data Models
```dart
// lib/models/tool.dart
class Tool {
  final int id;
  final String nama;
  final String? gambar;
  final String deskripsi;
  final String fungsi;
  final String? urlVideo;
  final String? filePdf;
  final String kategori;
  final bool isActive;
  final List<String>? tags;
  final int? categoryId;
  final Category? category;
  final DateTime createdAt;
  final DateTime updatedAt;
  
  Tool({
    required this.id,
    required this.nama,
    this.gambar,
    required this.deskripsi,
    required this.fungsi,
    this.urlVideo,
    this.filePdf,
    required this.kategori,
    required this.isActive,
    this.tags,
    this.categoryId,
    this.category,
    required this.createdAt,
    required this.updatedAt,
  });
  
  factory Tool.fromJson(Map<String, dynamic> json) {
    return Tool(
      id: json['id'],
      nama: json['nama'],
      gambar: json['gambar'],
      deskripsi: json['deskripsi'],
      fungsi: json['fungsi'],
      urlVideo: json['url_video'],
      filePdf: json['file_pdf'],
      kategori: json['kategori'],
      isActive: json['is_active'] ?? true,
      tags: json['tags'] != null ? List<String>.from(json['tags']) : null,
      categoryId: json['category_id'],
      category: json['category'] != null ? Category.fromJson(json['category']) : null,
      createdAt: DateTime.parse(json['created_at']),
      updatedAt: DateTime.parse(json['updated_at']),
    );
  }
}

// lib/models/category.dart
class Category {
  final int id;
  final String nama;
  final String slug;
  final String? deskripsi;
  final String? icon;
  final DateTime createdAt;
  final DateTime updatedAt;
  
  Category({
    required this.id,
    required this.nama,
    required this.slug,
    this.deskripsi,
    this.icon,
    required this.createdAt,
    required this.updatedAt,
  });
  
  factory Category.fromJson(Map<String, dynamic> json) {
    return Category(
      id: json['id'],
      nama: json['nama'],
      slug: json['slug'],
      deskripsi: json['deskripsi'],
      icon: json['icon'],
      createdAt: DateTime.parse(json['created_at']),
      updatedAt: DateTime.parse(json['updated_at']),
    );
  }
}
```

### API Endpoints
- **Get Tools**: `GET /tools?category_id={id}&search={query}&per_page={limit}`
- **Get Tool Detail**: `GET /tools/{id}`
- **Get Categories**: `GET /categories`

### 5. Videos Page

#### Videos List
- **Endpoint**: `GET /videos`
- **Data Model**:
```dart
class Video {
  int id;
  String judul;
  String deskripsi;
  String youtubeUrl;
  DateTime createdAt;
}
```
- **UI**: List dengan thumbnail YouTube, judul, dan deskripsi

#### Video Player
- **Package**: `youtube_player_flutter`
- **UI**: Full-screen video player dengan kontrol

### 6. Quiz Pages

#### Quiz Levels
- **Levels**: Mudah, Sedang, Sulit
- **UI**: Cards untuk setiap level dengan progress indicator

#### Quiz List by Level
- **Endpoint**: `GET /quizzes/{level}`
- **Levels**: mudah, sedang, sulit
- **Data Model**:
```dart
class Quiz {
  int id;
  String soal;
  String pilihanA;
  String pilihanB;
  String pilihanC;
  String pilihanD;
  String jawabanBenar;
  String level;
}
```

#### Quiz Taking Interface
- **UI**: 
  - Question counter (1/10)
  - Progress bar
  - Question text
  - Multiple choice options (A, B, C, D)
  - Next/Previous buttons
  - Timer (optional)

#### Submit Quiz
- **Endpoint**: `POST /quizzes/submit`
- **Payload**:
```json
{
  "level": "mudah",
  "answers": [
    {"quiz_id": 1, "jawaban": "A"},
    {"quiz_id": 2, "jawaban": "B"}
  ]
}
```
- **Response**: Score details

#### Quiz Results
- **UI**: 
  - Total score
  - Correct/Wrong answers
  - Percentage
  - Review answers (optional)
  - Retry button

#### Quiz History
- **Endpoint**: `GET /quizzes/history/user`
- **UI**: List riwayat kuis dengan tanggal, level, dan skor

#### Quiz Statistics
- **Endpoint**: `GET /quizzes/stats/user`
- **UI**: Charts dan statistik performa kuis

### 7. Scores & Leaderboard

#### Personal Scores
- **Endpoint**: `GET /scores`
- **Data Model**:
```dart
class Score {
  int id;
  int userId;
  int skor;
  int totalSoal;
  int benar;
  int salah;
  String level;
  DateTime tanggal;
  User? user;
}
```

#### Leaderboard
- **Endpoint**: `GET /leaderboard`
- **UI**: Ranking list dengan avatar, nama, dan total skor

### 8. Profile Page

#### View Profile
- **Endpoint**: `GET /profile`
- **Data Model**:
```dart
class User {
  int id;
  String name;
  String email;
  String? kelas;
  String? foto;
  String role;
  String? phone;
  String? bio;
  bool isActive;
  DateTime? lastLoginAt;
  Map<String, dynamic> progress;
}
```

#### Edit Profile
- **Endpoint**: `PUT /profile`
- **Fields**: name, email, kelas, phone, bio, foto
- **UI**: Form edit dengan image picker untuk foto profil

#### Change Password
- **Endpoint**: `PUT /change-password`
- **Fields**: current_password, password, password_confirmation
- **UI**: Form ganti password dengan validasi

#### Logout
- **Endpoint**: `POST /logout`
- **Action**: Clear token dan redirect ke login

## State Management
Gunakan **Provider** atau **Riverpod** untuk state management:

### Auth Provider
```dart
class AuthProvider extends ChangeNotifier {
  User? _user;
  String? _token;
  bool _isLoading = false;
  
  // Methods: login, register, logout, updateProfile, etc.
}
```

### Quiz Provider
```dart
class QuizProvider extends ChangeNotifier {
  List<Quiz> _quizzes = [];
  int _currentQuestionIndex = 0;
  Map<int, String> _answers = {};
  
  // Methods: loadQuizzes, submitAnswer, submitQuiz, etc.
}
```

## HTTP Service
Buat service class untuk API calls:

```dart
class ApiService {
  static const String baseUrl = 'http://127.0.0.1:8000/api';
  
  // Auth methods
  Future<AuthResponse> login(String email, String password);
  Future<AuthResponse> register(Map<String, dynamic> data);
  
  // Tools methods
  Future<List<Tool>> getTools({int? categoryId, String? search});
  Future<Tool> getTool(int id);
  
  // Quiz methods
  Future<List<Quiz>> getQuizzesByLevel(String level);
  Future<ScoreResponse> submitQuiz(String level, List<Answer> answers);
  
  // etc.
}
```

## UI/UX Guidelines

### Design System
- **Colors**: 
  - Primary: Blue (#2196F3)
  - Secondary: Green (#4CAF50)
  - Accent: Orange (#FF9800)
  - Error: Red (#F44336)

### Components
- **Custom AppBar** dengan gradient
- **Loading indicators** untuk async operations
- **Error handling** dengan SnackBar/Dialog
- **Empty states** untuk data kosong
- **Pull-to-refresh** untuk lists
- **Pagination** untuk data besar

### Navigation
- **Bottom Navigation** untuk main tabs
- **Drawer** untuk additional options (optional)
- **Named routes** untuk navigation

## Packages yang Direkomendasikan

```yaml
dependencies:
  flutter:
    sdk: flutter
  
  # State Management
  provider: ^6.0.5
  
  # HTTP
  http: ^0.13.5
  dio: ^5.3.2
  
  # Storage
  shared_preferences: ^2.2.2
  
  # UI
  cached_network_image: ^3.3.0
  shimmer: ^3.0.0
  
  # Media
  youtube_player_flutter: ^8.1.2
  image_picker: ^1.0.4
  
  # Utils
  intl: ^0.18.1
  url_launcher: ^6.2.1
  
  # Charts (for statistics)
  fl_chart: ^0.64.0

dev_dependencies:
  flutter_test:
    sdk: flutter
  flutter_lints: ^3.0.0
```

## Error Handling

### API Error Response Format
```json
{
  "message": "Error message",
  "errors": {
    "field": ["Validation error"]
  }
}
```

### Exception Handling
```dart
try {
  final response = await apiService.login(email, password);
  // Handle success
} on ApiException catch (e) {
  // Handle API errors
  showErrorSnackBar(e.message);
} catch (e) {
  // Handle other errors
  showErrorSnackBar('Terjadi kesalahan');
}
```

## Security
- **Token storage** menggunakan secure storage
- **Input validation** di client side
- **HTTPS** untuk production

Dengan struktur ini, aplikasi Flutter akan terintegrasi dengan baik dengan backend Laravel yang telah dibuat dan menyediakan pengalaman pembelajaran yang interaktif untuk pengguna.
