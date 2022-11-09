export interface Skill {
  name: string;
  subskill?: string;
  cost: number;
  ranks: number;
  statBonus: number;
  specialBonus: number;
}

export interface SkillSet {
  [key: string]: Skill[]
}
