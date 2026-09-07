from pathlib import Path
from pypdf import PdfReader

root = Path(r"C:\laragon\www\haro_proyect")
pdf = root / "output" / "pdf" / "documentacion_general_haro_seminuevos.pdf"
reader = PdfReader(str(pdf))
texts = [(page.extract_text() or "") for page in reader.pages]
empty_pages = [index + 1 for index, text in enumerate(texts) if len(text.strip()) < 40]
all_text = "\n".join(texts)

env_values = {}
env_path = root / ".env"
if env_path.exists():
    for raw in env_path.read_text(encoding="utf-8-sig").splitlines():
        line = raw.strip()
        if not line or line.startswith("#") or "=" not in line:
            continue
        key, value = line.split("=", 1)
        value = value.strip().strip('"').strip("'")
        if key.strip() in {"DB_USERNAME", "DB_PASSWORD", "FACEBOOK_ACCESS_TOKEN"} and len(value) >= 4:
            env_values[key.strip()] = value

leaked_keys = [key for key, value in env_values.items() if value in all_text]
required = [
    "Proyecto Haro Seminuevos",
    "Arquitectura de la solución",
    "Variables de entorno y conectividad",
    "Optimización de consultas",
    "Seguridad y hoja de ruta",
]
missing_sections = [title for title in required if title not in all_text]

print(f"pages={len(reader.pages)}")
print(f"empty_pages={empty_pages}")
print(f"missing_sections={missing_sections}")
print(f"leaked_secret_keys={leaked_keys}")
print(f"characters={len(all_text)}")
if empty_pages or missing_sections or leaked_keys:
    raise SystemExit(1)
