import { Username } from '@/Domain/User/Username'
import { UserRole } from '@/Domain/User/UserRole'

const parseRole = (role: string): UserRole => {
  const parsedRole = role.replace('ROLE_', '');
  return UserRole[parsedRole as keyof typeof UserRole]
}
const parseJwt = (token: string): { username: string, role: UserRole } => {
  const parsedData = JSON.parse(atob(token.split('.')[1]));
  const username = parsedData ? parsedData.username : '';
  const roles: string[] = parsedData ? parsedData.roles : [];
  const role = roles.filter((current: string) => {
    return current !== 'ROLE_USER'
  })
  if (roles.length === 0) {
    roles[0] = 'ROLE_USER'
  }
  return { username, role: parseRole(role[0]) }
};

export class User {
  private _username: Username
  private _role: UserRole

  public static fromToken(token: string): User
  {
    const data = parseJwt(token);
    return new this(new Username(data.username), data.role)
  }
  constructor (username: Username, role: UserRole) {
    this._username = username
    this._role = role
  }
  public username(): string {
    return this._username.value()
  }
  public role(): string {
    return this._role
  }
}