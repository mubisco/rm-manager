import { describe, test, expect } from 'vitest'
import { User } from '@/Domain/User/User'
import { Username } from '@/Domain/User/Username'
import { UserRole } from '@/Domain/User/UserRole'

describe('Testing User', () => {
  test('Should be of proper class', () => {
    const sut = new User(new Username('mubisco'), UserRole.ADMIN, '')
    expect(sut).toBeInstanceOf(User)
  })
  test('Should return proper data', () => {
    const sut = new User(new Username('mubisco'), UserRole.ADMIN, '')
    expect(sut.username()).toBe('mubisco')
    expect(sut.role()).toBe('ADMIN')
  })
  test('Should return proper data from named constructor', () => {
    const token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2NDgyODY2NDYsImV4cCI6MTY0ODI5MDI0Niwicm9sZXMiOlsiUk9MRV9BRE1JTiIsIlJPTEVfVVNFUiJdLCJ1c2VybmFtZSI6Im11YmlzY28ifQ.G_YoCCkb_rjZR4BvBaqgYF2QrbesQWTJ2nWevPOGiDb6DIk5hzlc7w2SPfwBKLOSNvuTHikT7ZynUEcsZX-TotP0ey2U7EbQTzxqCpggGH_FPhq0aLsD7Bhnm5s0eUE_cpu1I4hE1cjBwgiwGNd2TRU-xh34I5xM2YqNUfxKmdYcocHuzST8pBJDzfMEHybyEf2kakGh1bwzJTs-0uIGKuyhaNpx9BS6gd8oUtzqMabk3rjzeVGhROpsJ9zPpOhX81t1nMh7WKnnCW3JSlXSLUhw8VmJEWwKeWvOLLPdOGEMr5KgkHVB-AXnKHOFawfXce60fhtniivJ3eq6z1g-fQ"
    const sut = User.fromToken(token)
    expect(sut.username()).toBe('mubisco')
    expect(sut.role()).toBe('ADMIN')
    expect(sut.token()).toBe(token)
  })
  test('Should store user from master token', async () => {
    const token =  "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2NDgzMDE0NTAsImV4cCI6MTY0ODMwNTA1MCwicm9sZXMiOlsiUk9MRV9NQVNURVIiLCJST0xFX1VTRVIiXSwidXNlcm5hbWUiOiJkdW5nZW9uX21hc3RlciJ9.B0nJtrJguyKEtZxuu7pXpAlpS2seFklB-pDBQsok6N7zc5D25_oPxuRDfXpYYfCpA7PEqYNmiuqa-6LvhK2_kpAa5ZIz2ujMKWy2j1ohzILC_UQiAMLsDmen_E7NIrT9D9a3xXSICzhROoT6mS67BPTlLK7XLrpGH4cO6aBn8ib2F9izSSE8UhOYQWjAbk7k8jiyoP5aNWFFBFL0t9S6Yh70e_8LskyNxsvrol1G1IWLXJS0ytHM441WX-w6RUK0b7cczzK8CJSUhEtXyCo37WqKMPi7ifh78DILR3L70D9W7bxoxrHBVCdDm6voBnGdJkmik1KMRodU9fmB-4Ehww"

    const sut = User.fromToken(token)
    expect(sut.username()).toBe('dungeon_master')
    expect(sut.role()).toBe('MASTER')
    expect(sut.token()).toBe(token)
  })
  test('Should store user from player token', async () => {
   const token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2NDgyODY3ODgsImV4cCI6MTY0ODI5MDM4OCwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoibWluZHVuZGkifQ.GV8y6pTDSlcO1JFjceUihWHvOD_YH6rQPFLd-A0zJg9u_pr0NdSIQZ1GnuWEET2j0ndO-uoonJ6oEOmIDHJ45BIG1zeULyB1YLz9cwaU1e74QK0rq5ig8elPhpNwUh-wvZhDABCFYq5K0NYlur2aGL5IAfFCvmW9qo8KK-5NTWiS6zqoyooZGqJCh_WJMSloTe7VvmMxnFCxrHjREBqgQTRyGdIDQ17s1c8w6J4GwuRFSsIgxXIW78gIvrzM3PVabYb3Ow-sklGoGlsBY9qh3wEkF_kVxNsjIBo7KkCC3r8KdfIoIPMuQJOxt-3qSxxEHKVgevMCpWVhigdnRL8-Pw"

    const sut = User.fromToken(token)
    expect(sut.username()).toBe('mindundi')
    expect(sut.role()).toBe('USER')
    expect(sut.token()).toBe(token)
  })
})
