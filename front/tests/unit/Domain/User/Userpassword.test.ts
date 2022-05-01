import { describe, test, expect } from 'vitest'
import { Userpassword } from '@/Domain/User/Userpassword'
import { InvalidPasswordError } from '@/Domain/User/InvalidPasswordError'

describe('Testing Userpassword', () => {
  test('Should be of Proper class', () => {
    const sut = new Userpassword('password')
    expect(sut).toBeInstanceOf(Userpassword)
  })
  test('Should throw error on bad format', () => {
    expect(() => new Userpassword('xan')).toThrowError(InvalidPasswordError);
  })
  test('Should return proper password value', () => {
    const sut = new Userpassword('aL90ngpassword');
    expect(sut.value()).toBe('aL90ngpassword');
  })
})
