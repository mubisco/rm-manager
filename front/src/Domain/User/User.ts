import { Username } from '@/Domain/User/Username'
import { UserRole } from '@/Domain/User/UserRole'

const parseRole = (role: string): UserRole => {
  const parsedRole = role.replace('ROLE_', '');
  return UserRole[parsedRole as keyof typeof UserRole]
}
const parseJwt = (token: string): { username: string, role: UserRole } => {
  const parsedData = JSON.parse(window.atob(token.split('.')[1]));
  const username = parsedData ? parsedData.username : '';
  const roles: string[] = parsedData ? parsedData.roles : [];
  const role = roles.filter((current: string) => {
    return current !== 'ROLE_USER'
  })
  if (role.length === 0) {
    role[0] = 'ROLE_USER'
  }
  return { username, role: parseRole(role[0]) }
};

export class User {
  private _username: Username
  private _role: UserRole
  private _token: string

  public static fromToken(token: string): User
  {
    const data = parseJwt(token);
    return new this(new Username(data.username), data.role, token)
  }
  constructor (username: Username, role: UserRole, token: string) {
    this._username = username
    this._role = role
    this._token = token
  }
  public username(): string {
    return this._username.value()
  }
  public role(): string {
    return this._role
  }
  public token(): string {
    return this._token
  }
}
