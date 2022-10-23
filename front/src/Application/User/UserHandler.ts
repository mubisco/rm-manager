// eslint-disable-next-line
export interface UserHandler<T = any, K = any> {
  handle(message: T): K
}
