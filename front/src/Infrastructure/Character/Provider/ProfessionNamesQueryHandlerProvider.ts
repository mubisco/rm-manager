import { FetchAllProfessionNamesQueryHandler } from '@/Application/Profession/Query/FetchAllProfessionNamesQueryHandler'
import { FileProfessionReadModel } from '@/Infrastructure/Character/Profession/ReadModel/File/FileProfessionReadModel'
import { StorageUserRepository } from '@/Infrastructure/User/Persistence/Storage/StorageUserRepository'
import { AxiosProfessionReadModel } from '@/Infrastructure/Character/Profession/ReadModel/Axios/AxiosProfessionReadModel'

export class ProfessionNamesQueryHandlerProvider {
  provide (): FetchAllProfessionNamesQueryHandler {
    if (process.env.VITE_API_FAKE_ENV) {
      return new FetchAllProfessionNamesQueryHandler(new FileProfessionReadModel())
    }
    const repository = new StorageUserRepository()
    const readModel = new AxiosProfessionReadModel(repository)
    return new FetchAllProfessionNamesQueryHandler(readModel)
  }
}
