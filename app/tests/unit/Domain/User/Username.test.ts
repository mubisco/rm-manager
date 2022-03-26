import { describe, test, expect } from 'vitest'
import { Username } from '@/Domain/User/Username'
import { InvalidUsernameError } from '@/Domain/User/InvalidUsernameError'

describe('Testing Username', () => {
  test('Should throw error on bad format', () => {
    expect(() => new Username('xan@gmail.com')).toThrowError(InvalidUsernameError);
  })
  test('Should return proper username', () => {
    const sut = new Username('username');
    expect(sut.value()).toBe('username');
  })
  test('Should return proper username from diff instance', () => {
    const sut = new Username('mubisco');
    expect(sut.value()).toBe('mubisco');
  })
})

