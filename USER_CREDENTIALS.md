# LAU Paradise Adventure - User Credentials

## 🔐 Login Credentials for Testing

### ⚠️ Important: Staff Users Require OTP Verification

**Staff users (Admin, Super Admin, etc.) require OTP verification via email.** You have two options:

#### Option 1: Use Development OTP (Recommended)
1. Go to `http://127.0.0.1:8000/login`
2. Enter staff credentials (see below)
3. You'll be redirected to OTP verification page
4. Enter OTP code: `123456` (development OTP)
5. You'll be logged in successfully

#### Option 2: Bypass OTP (Development Only)
Add `?dev_bypass=1` to the login URL:
`http://127.0.0.1:8000/login?dev_bypass=1`

### Super Admin Users
| Email | Password | Role |
|-------|----------|------|
| superadmin@lauparadise.com | Admin@12345 | Super Admin |
| sysadmin@lauparadise.com | Admin@12345 | Admin |
| admin@lauparadise.com | lau123 | Lau Administrator |

### Staff Users
| Email | Password | Role |
|-------|----------|------|
| laurinemuhimbano@gmail.com | lau123 | Accountant |
| Laurancekilondera6@gmail.com | lau123 | Admin / General Manager |
| baltazaridionis@gmail.com | lau123 | Marketing Officer |
| john.smith@lauparadise.com | Staff@12345 | Tour Guide |
| sarah.j@lauparadise.com | Staff@12345 | Sales Agent |
| michael.d@lauparadise.com | Staff@12345 | Customer Service |
| emma.w@lauparadise.com | Staff@12345 | Marketing Officer |

### Customer Users (Direct Login - No OTP)
| Email | Password | Role |
|-------|----------|------|
| client@lauparadise.com | Client@12345 | Sample Client |
| robert.anderson@email.com | Customer@12345 | Customer |
| maria.garcia@email.com | Customer@12345 | Customer |
| james.taylor@email.com | Customer@12345 | Customer |
| lisa.chen@email.com | Customer@12345 | Customer |
| david.brown@email.com | Customer@12345 | Customer |
| sophie.martin@email.com | Customer@12345 | Customer |
| ahmed.hassan@email.com | Customer@12345 | Customer |
| nina.petrov@email.com | Customer@12345 | Customer |

## 🚀 Quick Start

1. **Super Admin Access**: Use `superadmin@lauparadise.com` / `Admin@12345` for full system access
2. **Staff Access**: Use any staff email with `Staff@12345` or `lau123` for staff functionality
3. **Customer Access**: Use any customer email with `Customer@12345` or `Client@12345` for customer portal

## 📝 Notes

- All passwords are case-sensitive
- Default admin password: `lau123`
- Default staff password: `Staff@12345`
- Default customer password: `Customer@12345`
- Super admin passwords: `Admin@12345`

## 🔧 Database Reset

To reset the database and reseed all users:
```bash
php artisan migrate:fresh --seed
```

To run specific seeders:
```bash
php artisan db:seed --class=SampleUsersSeeder
php artisan db:seed --class=DefaultStaffUsersSeeder
php artisan db:seed --class=ClientDemoSeeder
```

---
*Generated on: {{ date('Y-m-d H:i:s') }}*
