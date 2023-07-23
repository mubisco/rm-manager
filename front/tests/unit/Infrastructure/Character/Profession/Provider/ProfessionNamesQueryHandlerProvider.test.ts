import { beforeEach, describe, test, expect } from 'vitest'
import { ProfessionNamesQueryHandlerProvider } from '@/Infrastructure/Character/Provider/ProfessionNamesQueryHandlerProvider'

describe('Testing ProfessionQueryHandlerProvider', () => {
  test('It should be of proper class', () => {
    const sut = new ProfessionNamesQueryHandlerProvider()
    expect(sut).toBeInstanceOf(ProfessionNamesQueryHandlerProvider)
  })
})
