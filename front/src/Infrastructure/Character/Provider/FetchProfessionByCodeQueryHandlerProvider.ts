import { FetchProfessionByCodeQueryHandler } from '@/Application/Profession/Query/FetchProfessionByCodeQueryHandler'
import { FileProfessionReadModel } from '@/Infrastructure/Character/Profession/ReadModel/File/FileProfessionReadModel'
import { StorageUserRepository } from '@/Infrastructure/User/Persistence/Storage/StorageUserRepository'
import { AxiosProfessionReadModel } from '@/Infrastructure/Character/Profession/ReadModel/Axios/AxiosProfessionReadModel'

export class FetchProfessionByCodeQueryHandlerProvider {
  provide (): FetchProfessionByCodeQueryHandler {
    if (process.env.VITE_API_FAKE_ENV) {
      return new FetchProfessionByCodeQueryHandler(new FileProfessionReadModel())
    }
    const repository = new StorageUserRepository()
    const readModel = new AxiosProfessionReadModel(repository)
    return new FetchProfessionByCodeQueryHandler(readModel)
  }
}
