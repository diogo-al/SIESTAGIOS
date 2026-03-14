# 🎓 SIEstágios

Sistema de gestão de estágios curriculares desenvolvido no âmbito da
disciplina de Bases de Dados (ISCTE-IUL, 2025/2026).

## Sobre o projeto

Base de dados relacional e protótipo web para gestão de estágios de uma
escola profissional, com três perfis de utilizador distintos.

## Funcionalidades

**Base de dados (MariaDB)**
- Modelo relacional com 15+ entidades (alunos, empresas, estabelecimentos,
  estágios, formadores, zonas, transportes, ...)
- Triggers de validação (classificações, consistência de datas)
- Stored Procedures para registo e consulta de estágios
- Funções para cálculo de médias e notas ponderadas
- Views para relatórios de formadores e empresas

**Aplicação web (HTML/PHP)**
- Portal do Administrador — gestão completa de estágios e alunos
- Portal do Aluno — consulta de empresas e estágios, com filtros
- Portal do Formador — atribuição de notas e finalização de estágios

## Tecnologias

- **MariaDB** — modelação relacional, SQL DDL/DML
- **PHP** — lógica servidor, ligação à BD
- **HTML/CSS** — interface web

## Estrutura
```
db/
├── schema.sql        # DDL — criação das tabelas
├── data.sql          # Dados de teste
└── automatismos.sql  # Triggers, procedures e funções
web/
├── admin/            # Portal do Administrador
├── aluno/            # Portal do Aluno
└── formador/         # Portal do Formador
```
