import { describe, test, expect } from 'vitest'
import { User } from '@/Domain/User/User'
import { Username } from '@/Domain/User/Username'
import { UserRole } from '@/Domain/User/UserRole'

describe('Testing User', () => {
  test('Should be of proper class', () => {
    const sut = new User(new Username('mubisco'), UserRole.ADMIN)
    expect(sut).toBeInstanceOf(User)
  })
  test('Should return proper data', () => {
    const sut = new User(new Username('mubisco'), UserRole.ADMIN)
    expect(sut.username()).toBe('mubisco')
    expect(sut.role()).toBe('ADMIN')
  })
  test('Should return proper data from named constructor', () => {
    const token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2NDgyODY2NDYsImV4cCI6MTY0ODI5MDI0Niwicm9sZXMiOlsiUk9MRV9BRE1JTiIsIlJPTEVfVVNFUiJdLCJ1c2VybmFtZSI6Im11YmlzY28ifQ.G_YoCCkb_rjZR4BvBaqgYF2QrbesQWTJ2nWevPOGiDb6DIk5hzlc7w2SPfwBKLOSNvuTHikT7ZynUEcsZX-TotP0ey2U7EbQTzxqCpggGH_FPhq0aLsD7Bhnm5s0eUE_cpu1I4hE1cjBwgiwGNd2TRU-xh34I5xM2YqNUfxKmdYcocHuzST8pBJDzfMEHybyEf2kakGh1bwzJTs-0uIGKuyhaNpx9BS6gd8oUtzqMabk3rjzeVGhROpsJ9zPpOhX81t1nMh7WKnnCW3JSlXSLUhw8VmJEWwKeWvOLLPdOGEMr5KgkHVB-AXnKHOFawfXce60fhtniivJ3eq6z1g-fQ"
    const sut = User.fromToken(token)
    expect(sut.username()).toBe('mubisco')
    expect(sut.role()).toBe('ADMIN')
  })
})
